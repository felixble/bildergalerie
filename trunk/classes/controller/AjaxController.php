<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.02.16
 * Time: 07:41
 *
 * @JsonResponse
 */
class AjaxController extends BildergalerieController
{


    /**
     * Default action which will be executed
     * if no specific action is given.
     *
     * Each action returns the {@link View}
     * which will be displayed.
     *
     * @return View
     * @throws UnsupportedAjaxCall
     */
    public function indexAction()
    {
        throw new UnsupportedAjaxCall();
    }
}