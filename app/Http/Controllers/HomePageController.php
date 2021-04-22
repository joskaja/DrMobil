<?php


namespace App\Http\Controllers;


use App\Models\HomepageSlide;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomePageController extends Controller
{
    /**
     * Show e-shop homepage
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show()
    {
        return view('eshop.home', [
            'slides' => HomepageSlide::orderBy('created_at', 'desc')->get()
        ]);

    }

    /**
     * List all homepage slides in admin
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.home', [
            'slides' => HomepageSlide::orderBy('created_at', 'desc')->get()
        ]);

    }

    /**
     * Show add new homepage slide in admin
     * @return \Illuminate\Contracts\View\View|View
     */
    public function add() {
        return view('admin.slide', [
            'slide' => new HomepageSlide,
            'action' => route('admin.homepage.create')
        ]);
    }

    /**
     * Create new homepage slide
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function create(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'text' => 'required|string|max:255',
            'target_url' => 'required|url|max:255',
            'image' => 'required|image'
        ], [], [
            'name' => 'titulek slidu',
            'text' => 'text',
            'target_url' => 'cílová adresa',
            'image' => 'obrázek'
        ]);
        $slide = new HomepageSlide();
        $slide->fill($request->all());
        $image = (new ImageController)->store($request->file('image'), $request->name);
        $slide->image()->associate($image);
        $slide->save();
        session()->flash('success_message', 'Slide byl úspěšně přidán.');
        return redirect(route('admin.homepage'));
    }

    /**
     * Show edit homepage slide form
     * @param int $slide
     * @return \Illuminate\Contracts\View\View|View
     */
    public function edit(int $slide)
    {
        $slide = HomepageSlide::findOrFail($slide);
        return view('admin.slide', [
            'slide' => $slide,
            'action' => route('admin.homepage.update', $slide->id)
        ]);
    }

    /**
     * Update homepage slide
     * @param int $slide
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(int $slide, Request $request)
    {
        $slide = HomepageSlide::findOrFail($slide);
        $request->validate([
            'name' => 'required|string|max:255',
            'text' => 'required|string|max:255',
            'target_url' => 'required|url|max:255',
            'image' => 'image'
        ], [], [
            'name' => 'titulek slidu',
            'text' => 'text',
            'target_url' => 'cílová adresa',
            'image' => 'obrázek'
        ]);
        $slide->fill($request->all());
        $old_image = false;
        if($request->hasFile('image')) {
            $old_image = $slide->image();
            $image = (new ImageController)->store($request->file('image'), $request->name);
            $slide->image()->associate($image);
        }
        $slide->save();
        if($old_image) $old_image->delete();
        session()->flash('success_message', 'Slide byl úspěšně upraven.');
        return redirect(route('admin.homepage'));    }

    /**
     * Delete homepage slide
     * @param int $slide
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function delete(int $slide): \Illuminate\Http\RedirectResponse
    {
        $slide = HomepageSlide::find($slide);
        if($slide) {
            $slide->delete();
            session()->flash('success_message', 'Slide byl úspěšně odstraněn');
        } else {
            session()->flash('error_message', 'Něco se nepovedlo');
        }
        return redirect()->back();
    }
}
