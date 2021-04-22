<?php


namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\View\View;

trait DialsControllerFunctions
{
    /**
     * @return \Illuminate\Contracts\View\View|View
     */
    public function index()
    {
        return view('admin.dials', [
            'dials' => $this->model::all(),
            'route' => $this->route,
            'name' => $this->name
        ]);
    }
    /**
     * @return \Illuminate\Contracts\View\View|View
     */
    public function add() {
        $modelObj = new $this->model();
        return view('admin.dial', [
            'dial' => $modelObj,
            'action' => route($this->route . '.add'),
            'route' => $this->route,
            'name' => $this->name
        ]);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function create(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $modelObj = new $this->model();
        $modelObj->fill($request->all());
        $modelObj->save();
        session()->flash('success_message', 'Položka číselníku byla úspěšně přidána.');
        return redirect(route($this->route));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View|View
     */
    public function edit(int $id)
    {
        $modelObj = $this->model;
        $modelObj = $modelObj::findOrFail($id);
        return view('admin.dial', [
            'dial' => $modelObj,
            'action' => route($this->route . '.update', ['dial' => $modelObj->id]),
            'route' => $this->route,
            'name' => $this->name
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(int $id, Request $request)
    {
        $modelObj = $this->model;
        $modelObj = $modelObj::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $modelObj->fill($request->all());
        $modelObj->save();
        session()->flash('success_message', 'Položka číselníku byla úspěšně upravena.');
        return redirect(route($this->route));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function delete(int $id): \Illuminate\Http\RedirectResponse
    {
        $modelObj = $this->model;
        $modelObj = $modelObj::find($id);
        if($modelObj) {
            $modelObj->delete();
            session()->flash('success_message', 'Položka číselníku byla úspěšně odstraněna');
        } else {
            session()->flash('error_message', 'Něco se nepovedlo');
        }
        return redirect()->back();
    }

}
