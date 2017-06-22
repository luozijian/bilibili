<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBarrageAPIRequest;
use App\Http\Requests\API\UpdateBarrageAPIRequest;
use App\Models\Barrage;
use App\Models\User;
use App\Repositories\BarrageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class BarrageController
 * @package App\Http\Controllers\API
 */

class BarrageAPIController extends InfyOmBaseController
{
    /** @var  BarrageRepository */
    private $barrageRepository;

    public function __construct(BarrageRepository $barrageRepo)
    {
        $this->barrageRepository = $barrageRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/barrages",
     *      summary="Get a listing of the Barrages.",
     *      tags={"Barrage"},
     *      description="Get all Barrages",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Barrage")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->barrageRepository->pushCriteria(new RequestCriteria($request));
        $this->barrageRepository->pushCriteria(new LimitOffsetCriteria($request));
        $barrages = $this->barrageRepository->all();

        return $this->sendResponse($barrages->toArray(), 'Barrages retrieved successfully');
    }

    /**
     * @param CreateBarrageAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/barrages",
     *      summary="Store a newly created Barrage in storage",
     *      tags={"Barrage"},
     *      description="Store Barrage",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Barrage that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Barrage")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Barrage"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateBarrageAPIRequest $request)
    {
        $input = $request->all();

        $barrages = $this->barrageRepository->create($input);
        $barrages['user_avatar'] = User::find($input['user_id'])->avatar;

        return $this->sendResponse($barrages->toArray(), 'Barrage saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/barrages/{id}",
     *      summary="Display the specified Barrage",
     *      tags={"Barrage"},
     *      description="Get Barrage",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Barrage",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Barrage"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Barrage $barrage */
        $barrage = $this->barrageRepository->find($id);

        if (empty($barrage)) {
            return Response::json(ResponseUtil::makeError('Barrage not found'), 404);
        }

        return $this->sendResponse($barrage->toArray(), 'Barrage retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateBarrageAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/barrages/{id}",
     *      summary="Update the specified Barrage in storage",
     *      tags={"Barrage"},
     *      description="Update Barrage",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Barrage",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Barrage that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Barrage")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Barrage"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateBarrageAPIRequest $request)
    {
        $input = $request->all();

        /** @var Barrage $barrage */
        $barrage = $this->barrageRepository->find($id);

        if (empty($barrage)) {
            return Response::json(ResponseUtil::makeError('Barrage not found'), 404);
        }

        $barrage = $this->barrageRepository->update($input, $id);

        return $this->sendResponse($barrage->toArray(), 'Barrage updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/barrages/{id}",
     *      summary="Remove the specified Barrage from storage",
     *      tags={"Barrage"},
     *      description="Delete Barrage",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Barrage",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Barrage $barrage */
        $barrage = $this->barrageRepository->find($id);

        if (empty($barrage)) {
            return Response::json(ResponseUtil::makeError('Barrage not found'), 404);
        }

        $barrage->delete();

        return $this->sendResponse($id, 'Barrage deleted successfully');
    }
}
