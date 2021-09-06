<?php

namespace App\Http\Controllers\admin;

use App\Exports\TagExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManagerTagController extends Controller
{

    public function index()
    {
        $tags = Tag::all();
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.createOrUpdate')->with([
            'tag'    => new Tag(),
            'action' => 'create',
        ]);
    }

    public function store(TagRequest $request)
    {
        $action = Tag::create($request->only('en_name', 'vi_name'));
        if ($action) alert()->success(__('custom.Notification'), __('custom.tag_add_success'));
        else alert()->error(__('custom.Notification'), __('custom.message_order_error_db'));

        return redirect()->route('tag.index');
    }

    public function edit($id)
    {
        $tag = Tag::findById($id);

        return view('admin.tags.createOrUpdate')->with([
            'tag'    => $tag,
            'action' => 'update',
        ]);
    }

    public function update(TagRequest $request, $id)
    {
        $action = Tag::updateTag($id, $request->only('en_name', 'vi_name'));
        if ($action) alert()->success(__('custom.Notification'), __('custom.tag_update_success'));
        else alert()->error(__('custom.Notification'), __('custom.message_order_error_db'));

        return redirect()->route('tag.index');
    }

    public function destroy($id)
    {
        $action = Tag::destroy($id);
        if ($action) alert()->success(__('custom.Notification'), __('custom.tag_delete_success'));
        else alert()->error(__('custom.Notification'), __('custom.message_order_error_db'));

        return redirect()->route('tag.index');
    }

    public function filterDate(Request $request)
    {
        $dayOne = $request->findDayOne;
        $dayTwo = $request->findDayTwo;
        if ($dayOne < $dayTwo) {
            $tags = Tag::getByBetweenDay($dayOne, $dayTwo)->get();
        }
        else if ($dayOne == $dayTwo) {
            $tags = Tag::getDayNow()->get();
        }
        else {
            $tags = Tag::all();
            alert()->error(__('custom.Notification'), __('custom.tag_filter_error'));
        }

        return view('admin.tags.index', compact('tags'));
    }

    public function exportExcel($type)
    {
        return Excel::download(new TagExport($type), 'list_tags.xlsx');
    }
}
