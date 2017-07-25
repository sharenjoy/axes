<?php namespace Sharenjoy\Cmsharenjoy\Http\Controllers;

use Illuminate\Http\Request;
use Sharenjoy\Cmsharenjoy\Utilities\Transformer;
use Lister, Formaker;

abstract class ObjectBaseController extends BaseController {

    /**
     * The model to work with for editing stuff
     */
    protected $repo;

    /**
     * The relations need to be fetch from the Eloquent
     * @var array
     */
    protected $relations = [];

    /**
     * The default number of pagination
     * @var integer
     */
    protected $paginationCount;

    /**
     * These are the data of array that don't need to filter
     * @var array
     */
    protected $filterExcept = ['filter', 'perPage', 'page'];

    /**
     * ObjectBaseController construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('admin.switchPaginationCount', ['only' => 'getIndex']);

        $this->middleware('admin.setGoBackPrevious', ['only' => ['getIndex', 'getSort']]);

        $this->paginationCount = config('cmsharenjoy.paginationCount');
    }

    /**
     * Main users page.
     * @return   View
     */
    public function getIndex(Request $request)
    {
        $this->repo->grabAllLists();
        
        $model = $this->repo->makeQuery();

        if ($request->has('filter')) {
            $filter = array_except($request->query(), $this->filterExcept);
            $model = $this->repo->filter($filter, $model);
        }

        $limit = $request->input('perPage', $this->paginationCount);
        
        $items = $this->repo->showByPage($limit, $request->query(), $model->with($this->relations));
        
        $forms = Formaker::setModel($this->repo->getModel())->make($request->all());

        $data = ['paginationCount'=>$limit, 'sortable'=>false, 'rules'=>$this->functionRules];
        $lister = Lister::make($items, $this->listConfig, $data);

        event('controllerAfterAction', ['']);

        return $this->layout()->with('filterForm', $forms)
                              ->with('listEmpty', $items->isEmpty())
                              ->with('lister', $lister);
    }

    /**
     * To sort item of page.
     * @return   View
     */
    public function getSort(Request $request)
    {
        $this->repo->grabAllLists();

        $model = $this->repo->makeQuery();

        $sortable = true;

        if ($this->repo->isSortFilterFormConfigExists()){
            $sortable = false;

            if ($request->has('filter')) {
                $sortable = true;
                $filter   = array_except($request->query(), $this->filterExcept);
                
                foreach ($filter as $item) {
                    if (! $item) $sortable = false;
                }

                $model = $this->repo->filter($filter, $model);
            }

            view()->share('beforeSortShouldFilter', ! $sortable);
            view()->share('filterForm', Formaker::setModel($this->repo->getModel())->make($request->all()));
        }

        $limit = $request->input('perPage', $this->paginationCount);

        $items = $this->repo->showByPage($limit, $request->query(), $model->with($this->relations));

        $data = ['paginationCount'=>$limit, 'sortable'=>$sortable, 'rules'=>$this->functionRules];
        $lister = Lister::make($items, $this->listConfig, $data);
        
        event('controllerAfterAction', ['']);

        return $this->layout()->with('listEmpty', $items->isEmpty())
                              ->with('sortable', $sortable)
                              ->with('lister', $lister);
    }

    /**
     * The new object
     * @return View
     */
    public function getCreate()
    {
        $fields = Formaker::setModel($this->repo->getModel())->make();

        return $this->layout()->with('fieldsForm', $fields);
    }

    /**
     * The generic method for the start of editing something
     * @return View
     */
    public function getUpdate($id)
    {
        $model = $this->repo->showById($id);

        if ( ! $model)
        {
            error(pick_trans('exception.not_found', ['id' => $id]));

            return redirect(session('goBackPrevious'));
        }

        $fields = Formaker::setModel($this->repo->getModel())->make($model->toArray());

        event('controllerAfterAction', [$model]);

        return $this->layout()->with('item', $model)->with('fieldsForm', $fields);
    }

    /**
     * The new object method, very generic, 
     * just allows mass assignable stuff to be filled and saved
     * @return Redirect
     */
    public function postCreate(Request $request)
    {
        $this->repo->setInput($request->all());

        if ( ! $this->repo->validate())
        {
            return redirect($this->createUrl)->withInput();
        }

        $model = $this->repo->create();

        $model ? success(pick_trans('success_created'))
               : error(pick_trans('fail_created'));
        
        $redirect = $request->has('exit') ? $this->objectUrl : $this->updateUrl.$model->id;

        return redirect($redirect);
    }

    /**
     * The method to handle the posted data
     * @param  integer $id The ID of the object
     * @return Redirect
     */
    public function postUpdate(Request $request, $id)
    {
        $this->repo->setInput($request->all(), $id);

        if ( ! $this->repo->validate($id))
        {
            return redirect($this->updateUrl.$id)->withInput();
        }

        $result = $this->repo->update($id);

        $result ? success(pick_trans('success_updated'))
                : error(pick_trans('fail_updated'));

        $redirect = $request->has('exit') ? session('goBackPrevious') : $this->updateUrl.$id;

        return redirect($redirect);
    }

    /**
     * Delete an object based on the ID passed in
     * @param  integer $id The object ID
     * @return Redirect
     */
    public function postDelete(Request $request)
    {
        $id     = $request->input('id');
        $model  = $this->repo->showById($id);
        $result = $this->repo->delete($id);

        $result ? success(pick_trans('success_deleted'))
                : error(pick_trans('fail_deleted'));
        
        event('controllerAfterAction', [$model]);

        return redirect(session('goBackPrevious'));
    }

    /**
     * Before delete an object get some information
     * @return Response object
     */
    public function postDeleteconfirm(Request $request)
    {
        if( ! $request->ajax()) response()->json('error', 400);

        $id    = $request->input('id');
        $model = $this->repo->showById($id);

        if ( ! $model)
        {
            $message = pick_trans('exception.not_found', ['id' => $id]);

            return message()->json(404, $message);
        }

        $result['title']   = Transformer::title($model);
        $result['subject'] = pick_trans('confirm_deleted');

        return message()->json(200, '', $result);
    }

    /**
     * Set the order of the list
     * @return Response
     */
    public function postOrder(Request $request)
    {
        // This should only be accessible via AJAX you know...
        if( ! $request->ajax()) response()->json('error', 400);

        $id_value   = $request->input('id_value');
        $sort_value = $request->input('sort_value');
        
        foreach($id_value as $key => $id)
        {
            if($id)
            {
                try
                {
                    $sort = $sort_value[$key];
                    $this->repo->edit($id, array('sort' => $sort));
                }
                catch (\Sharenjoy\Cmsharenjoy\Exception\EntityNotFoundException $e)
                {
                    error(pick_trans('exception.not_found', ['id' => $id]));
                    return redirect($this->objectUrl);
                }
            }
        }

        $message = pick_trans('success_ordered');
        $data = ['success' => pick_trans('success')];
        
        return message()->json(200, $message, $data);
    }
    
}