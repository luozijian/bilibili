<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBarrageRequest;
use App\Http\Requests\UpdateBarrageRequest;
use App\Models\Subtitle;
use App\Repositories\BarrageRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use App\Services\FirstLoginService;
use Illuminate\Http\Request;
use Flash;
use App\Criteria\RequestCriteria;
use Response;

class BarrageController extends InfyOmBaseController
{
    /** @var  BarrageRepository */
    private $barrageRepository;

    public function __construct(BarrageRepository $barrageRepo)
    {
        parent::__construct();
        $this->barrageRepository = $barrageRepo;
    }

    /**
     * Display a listing of the Barrage.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
    	\Session::put("barrage_back_url",$request->getRequestUri());
        $this->barrageRepository->pushCriteria(new RequestCriteria($request))->orderBy('id','desc');
        $barrages = $this->barrageRepository->paginate(15);

        return view('barrages.index')
            ->with('barrages', $barrages);
    }

    /**
     * Show the form for creating a new Barrage.
     *
     * @return Response
     */
    public function create()
    {
        return view('barrages.create');
    }

    /**
     * Store a newly created Barrage in storage.
     *
     * @param CreateBarrageRequest $request
     *
     * @return Response
     */
    public function store(CreateBarrageRequest $request)
    {
        $input = $request->all();

        $barrage = $this->barrageRepository->create($input);

        Flash::success('新增成功');

        return redirect(session('barrage_back_url',route('barrages.index')));
    }

    /**
     * Display the specified Barrage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $barrage = $this->barrageRepository->findWithoutFail($id);

        if (empty($barrage)) {
            Flash::error('找不到页面');

            return redirect(session('barrage_back_url',route('barrages.index')));
        }

        return view('barrages.show')->with('barrage', $barrage);
    }

    /**
     * Show the form for editing the specified Barrage.
     *
     * @param  int $id
     *
     * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View|Response
     */
    public function edit($id)
    {
        $barrage = $this->barrageRepository->findWithoutFail($id);

        if (empty($barrage)) {
            Flash::error('找不到页面');

            return redirect(session('barrage_back_url',route('barrages.index')));
        }

        return view('barrages.edit')->with('barrage', $barrage);
    }

    /**
     * Update the specified Barrage in storage.
     *
     * @param  int              $id
     * @param UpdateBarrageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBarrageRequest $request)
    {
        $barrage = $this->barrageRepository->findWithoutFail($id);

        if (empty($barrage)) {
            Flash::error('找不到页面');

            return redirect(session('barrage_back_url',route('barrages.index')));
        }

        $input=$request->all();

        $barrage = $this->barrageRepository->update($input, $id);

        Flash::success('编辑成功');

        return redirect(session('barrage_back_url',route('barrages.index')));
    }

    /**
     * Remove the specified Barrage from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $barrage = $this->barrageRepository->findWithoutFail($id);

        if (empty($barrage)) {
            Flash::error('找不到页面');

            return redirect(session('barrage_back_url',route('barrages.index')));
        }

        $this->barrageRepository->delete($id);

        Flash::success('删除成功');

        return redirect(session('barrage_back_url',route('barrages.index')));
    }

    public function polling()
    {
        $service = new FirstLoginService();
        $service->firstLogin();

        $chinese_subtitles = json_encode(Subtitle::where('type','chinese')->get());
        $english_subtitles = addslashes(json_encode(Subtitle::where('type','english')->get()));//转义

        return view('barrages.polling',compact('chinese_subtitles','english_subtitles'));
    }

    public function socket()
    {
        $service = new FirstLoginService();
        $service->firstLogin();

        $chinese_subtitles = json_encode(Subtitle::where('type','chinese')->get());
        $english_subtitles = addslashes(json_encode(Subtitle::where('type','english')->get()));//转义

        return view('barrages.socket',compact('chinese_subtitles','english_subtitles'));
    }
}
