<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\V2Game;
use DB;
use Modules\Admin\Repositories\GameRulesRepository;

class PercentManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // getting game list
        $games = V2Game::where('id', '!=', 1)->get(['name', 'alias']);

        return view('admin::percent-manager.index', ['games' => $games]);
    }

    /**
     * Show the specified resource.
     * @param string $id
     * @return Response
     */
    public function show($alias)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(string $alias)
    {
        $percentagesRulesJson = GameRulesRepository::getPercentagesRulesByAlias($alias);

        $percentagesRules = json_decode($percentagesRulesJson);

        return view('admin::percent-manager.percentages', [
            'alias' => $alias,
            'percentagesRules' => $percentagesRules
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, string $alias)
    {
        // получене данных из формы
        $requestArray = $request->all();
        unset($requestArray['_token']);

        // получение процентов
        $percentagesRulesJson = GameRulesRepository::getPercentagesRulesByAlias($alias);
        $percentagesRules = json_decode($percentagesRulesJson);

        // обновление процентов данными из формы
        foreach ($requestArray as $jsonData => $inputValue) {
            $percentData = json_decode($jsonData);

            foreach ($percentagesRules as $key => $percentagesRule) {
                if ($percentagesRule->bet === $percentData->bet) {
                    $type = $percentData->type;
                    $drum = $percentData->drum;
                    $symbol = $percentData->symbol;

                    $percentagesRule->$type[$drum][$symbol] = $inputValue;
                    $percentagesRules[$key] = $percentagesRule;
                }
            }
        }

        // сохранение результата
        GameRulesRepository::savePercentagesRulesByAlias($alias, $percentagesRules);

        return view('admin::percent-manager.percentages', [
            'alias' => $alias,
            'percentagesRules' => $percentagesRules
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
