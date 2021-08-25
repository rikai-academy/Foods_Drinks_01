<?php

namespace App\Services;


use App\Enums\UserRole;
use App\Jobs\AdminMailJob;
use App\Models\Evaluates;
use App\Models\User;
use Carbon\Carbon;
use DB;

class RatingService {

    /**
     * Insert Rating to Database.
     *
     * @param $data
     * @return int
     */
    public function ratingProduct($data)
    {
        $ratingId = $this->create($data);
        if ($ratingId) {
            $evaluate   = Evaluates::findById($ratingId);
            $params['created_at']  = $evaluate->created_at;
            $params['rating']      = $evaluate->rating;
            $params['userEmail']   = $evaluate->users()->first()->email;
            $params['userName']    = $evaluate->users()->first()->name;
            $params['productName'] = $evaluate->products()->first()->name;
            $params['date']        = checkLanguageWithDay($params['created_at']);

            # Send mail to user and admin
            $this->sendMailToUser($params);
            $this->sendMailToAdmin($params);
        }

        return $ratingId;
    }

    /**
     * Insert review to Database.
     *
     * @param $data
     * @return integer
     */
    private function create($data)
    {
        $timestamps = Carbon::now();
        return DB::table('evaluates')->insertGetId([
            'review'      => $data['review'],
            'rating'      => $data['rating'],
            'user_id'     => $data['user_id'],
            'product_id'  => $data['product_id'],
            'created_at'  => $timestamps,
            'updated_at'  => $timestamps,
        ]);
    }

    /**
     * Send mail to Admin.
     *
     * @param $params
     */
    private function sendMailToUser($params) {
        $message_en  = "You have rated product '" . $params['productName'] . "' with a star rating of " .
            $params['rating'] . ". At " . $params['date'] . ".";
        $message_vi  = "Bạn đã đánh giá sản phẩm '" . $params['productName'] . "' với số sao là " .
            $params['rating']. ". Lúc " . $params['date'] . ".";

        $details = [
          'title'  => '',
          'body'   => checkLanguage($message_en, $message_vi),
          'orders' => [],
          'locale' => session('website_language'),
        ];

        # Send mail to user
        AdminMailJob::dispatch($params['userEmail'], $details);
    }

    /**
     * Send mail to Admin.
     *
     * @param $params
     */
    private function sendMailToAdmin($params) {
        $message_en = $params['userName'] . "rated product '" . $params['productName'] . "' " . $params['rating'] .
            " stars at " . $params['date'] . ".";
        $message_vi = $params['userName'] . " đã đánh giá " . $params['rating'] . " sao sản phẩm '" .
            $params['productName'] . "' lúc " . $params['date'] . ".";

        $details = [
          'title'  => __('custom.message_mail_rating_title'),
          'body'   => checkLanguage($message_en, $message_vi),
          'orders' => [],
          'locale' => session('website_language'),
        ];

        # Send mail to Admin
        $emailOfAdmin = User::byRole(UserRole::getKey(0))->first()->email;
        AdminMailJob::dispatch($emailOfAdmin, $details);
    }
}
