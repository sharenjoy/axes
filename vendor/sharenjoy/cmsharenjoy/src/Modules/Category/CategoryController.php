<?php namespace Sharenjoy\Cmsharenjoy\Modules\Category;

use Sharenjoy\Cmsharenjoy\Http\Controllers\ObjectBaseController;
use Illuminate\Http\Request;
use Categorize, Lister;

class CategoryController extends ObjectBaseController {

    protected $functionRules = [
        'list'   => true,
        'create' => true,
        'update' => true,
        'delete' => true,
    ];

    protected $listConfig = [
        'type'         => ['name'=>'type',         'align'=>'center', 'width'=>'25%'],
        'title'        => ['name'=>'title',        'align'=>'',       'width'=>''   ],
        'slug'         => ['name'=>'slug',         'align'=>'',       'width'=>''   ],
    ];

    protected $type;

    protected $categoryLayerNumber;

    public function __construct(CategoryInterface $repo, Request $request)
    {
        $this->repo = $repo;

        $this->categoryLayerNumber = config('module.category.layer');

        if ($request->query('category'))
        {
            session()->put('sharenjoy.categoryType', $request->query('category'));
        }

        $this->type = session('sharenjoy.categoryType');

        parent::__construct();

        view()->share('specifyName', pick_trans('menu.'.$this->type.'_category'));
    }

    protected function getCategoryLayerNumber($type)
    {
        return array_get($this->categoryLayerNumber, $type);
    }

    public function getIndex(Request $request)
    {
        $type  = $this->type;
        $limit = $this->repo->getModel()->whereType($type)->count();
        $num = $this->getCategoryLayerNumber($type);

        $categories = Categorize::getCategoryProvider()->root()->whereType($type)->orderBy('sort')->get();

        $categories = Categorize::tree($categories)->toArray();

        $items = Categorize::getCategoryProvider()->whereType($type)->orderBy('sort')->paginate($limit);

        $data = ['paginationCount'=>$limit, 'sortable'=>false, 'rules'=>$this->functionRules];
        $lister = Lister::make($items, $this->listConfig, $data);

        return $this->layout()->with('listEmpty', $items->isEmpty())
                              ->with('lister', $lister)
                              ->with('categoryLevelNum', $num)
                              ->with('categories', $categories);
    }

    public function postOrder(Request $request)
    {
        if( ! $request->ajax()) response()->json('error', 400);

        $result  = json_decode($request->input('sort_value'), true);
        $sortNum = 0;

        foreach ($result as $keyOne => $valueOne)
        {
            $categoryOne = Categorize::getCategoryProvider()->findById($valueOne['id']);
            $categoryOne->makeRoot();
            $this->storeSortById($categoryOne, ++$sortNum);

            if(isset($valueOne['children']) && count($valueOne['children']))
            {
                foreach ($valueOne['children'] as $keyTwo => $valueTwo)
                {
                    $categoryTwo = Categorize::getCategoryProvider()->findById($valueTwo['id']);
                    $categoryTwo->makeChildOf($categoryOne);
                    $this->storeSortById($categoryTwo, ++$sortNum);

                    if(isset($valueTwo['children']) && count($valueTwo['children']))
                    {
                        foreach ($valueTwo['children'] as $keyThree => $valueThree)
                        {
                            $categoryThree = Categorize::getCategoryProvider()->findById($valueThree['id']);
                            $categoryThree->makeChildOf($categoryTwo);
                            $this->storeSortById($categoryThree, ++$sortNum);
                        }
                    }
                }
            }
        }

        return message()->json(200, pick_trans('success_ordered'));
    }

    public function getCreate()
    {
        $this->pushForm();
        return parent::getCreate();
    }

    public function getUpdate($id)
    {
        $this->pushForm();
        return parent::getUpdate($id);
    }

    private function pushForm()
    {
        $this->repo->getModel()->pushForm([
            'type' => [
                'args'  => ['value'=>$this->type, 'readonly'=>'readonly'],
                'order' => '10'
            ]
        ]);
    }

    protected function storeSortById($model, $sortNum)
    {
        $this->repo->edit($model->id, ['sort' => $sortNum]);
    }

}