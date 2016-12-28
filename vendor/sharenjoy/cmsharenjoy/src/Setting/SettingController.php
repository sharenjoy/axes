<?php namespace Sharenjoy\Cmsharenjoy\Setting;

use Illuminate\Http\Request;
use Sharenjoy\Cmsharenjoy\Http\Controllers\BaseController;
use Message, Form;

class SettingController extends BaseController {

    public function __construct(SettingInterface $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }

    public function getIndex()
    {
        $buttons = Form::button(pick_trans('buttons.save'), ['class'=>'btn btn-success btn-save']).'&nbsp;'.
                   Form::button(pick_trans('buttons.reset'), ['class'=>'btn btn-reset']);

        return $this->layout()->with('items', $this->item())
                              ->with('buttons', $buttons);
    }

    public function postStore(Request $request)
    {
        if( ! $request->ajax()) response()->json('error', 400);

        $data['item']  = $request->input('item');
        $data['value'] = $request->input('value');

        if ($request->input('type') == 'checkbox' && $data['value'] != '')
        {
            $array = explode('&', $data['value']);
            foreach($array as $value)
            {
                $val = explode('=', $value);
                $ary[] = $val[1];
            }
            $data['value'] = implode(',', $ary);
        }

        try
        {
            $this->repo->edit($data['item'], ['value' => $data['value']], 'key');
        }
        catch (\Sharenjoy\Cmsharenjoy\Exception\EntityNotFoundException $e)
        {
            return Message::json(400, pick_trans('fail_updated'), $data);
        }

        return Message::json(200, pick_trans('success_updated'), $data);
    }

    protected function item()
    {
        $model = $this->repo->getModel();
        $modules = $model->select('module')->groupBy('module')->orderBy('id')->pluck('module')->toArray();

        foreach ($modules as $module) {
            $items[$module]['item'] = $model->where('module', $module)->whereHidden(false)->orderBy('sort')->get();
        }

        return $items;
    }

}