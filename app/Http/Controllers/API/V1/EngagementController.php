<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Engagement\Application\EngagementManagement;

class EngagementController extends Controller
{

    protected $engagement;

    public function __construct(EngagementManagement $engagement){
        $this->engagement = $engagement;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->engagement->allData();

        return apiResponseBuilder(200, $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createEngagement(Request $request)
    {
        $data = $this->engagement->storeEngagement($request);

        return apiResponseBuilder(200, $data, 'Engagement has been created');

    }

    /**
     * For acc the engagement
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function acc(Request $request)
    {
        $data = $this->engagement->actionEngagement($request->id, 'acc');

        return apiResponseBuilder(200, $data);
    }

    /**
     * For ignore the engagement
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ignore(Request $request)
    {
        $data = $this->engagement->actionEngagement($request->id, 'ignore');

        return apiResponseBuilder(200, $data);
    }

    /**
     * For finish the engagement
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function finish(Request $request)
    {
        $data = $this->engagement->actionEngagement($request->id, 'finish');

        return apiResponseBuilder(200, $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $data = $this->engagement->view($id);

        return apiResponseBuilder(200, $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAvailableDate()
    {
        $data = $this->engagement->getDate();

        return apiResponseBuilder(200, $data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->engagement->delete($id);

        return apiResponseBuilder(200, $data, 'Engagement has been deleted');
    }
}
