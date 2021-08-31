<?php

use App\Models\ProductTag;
use App\Enums\UserRole;
use App\Models\User;
use Carbon\Carbon;
use App\Enums\Status;

if (!function_exists('displayStar')) {
    function displayStar()
    {
        $htmlStar = '';
        for($i = 1; $i < 6; $i++) {
            $htmlStar .= "<i class=\"fa fa-star product-star-rating\" id=\"starRating$i\" aria-hidden=\"true\"></i>&nbsp;";
        }
        return $htmlStar;
    }
}

if (!function_exists('displayStatusOrder')) {
    function displayStatusOrder($status)
    {
        if ($status === \App\Enums\Status::BLOCK) {
            return "<span class='label label-warning'>" . __('custom.message_order_processing') . "</span>";
        }
        if ($status === \App\Enums\Status::CANCEL) {
            return "<span class='label label-danger'>" . __('custom.message_order_status_cancel') . "</span>";
        }
        return "<span class='label label-success'>" . __('custom.message_order_success') . "</span>";
    }

    if (!function_exists('displayCancelOrder')) {
        function displayCancelOrder($created_at, $orderId, $status)
        {
            # Calculate current date with creation date
            $interval = $created_at->diffInDays(Carbon::now());
            $htmlFormCancelOrder = "";
            if ($interval === 0 && $status === Status::BLOCK) {
                $htmlFormCancelOrder .= "<form action='" . route('order-cancel')
                    . "' id='formCancelOrder' method='post'>";
                $htmlFormCancelOrder .= csrf_field();
                $htmlFormCancelOrder .= "<input type='hidden' name='orderId' value='$orderId'>";
                $htmlFormCancelOrder .= "<button type='submit' class='btn btn-danger'>"
                    . __('custom.order_cancel') . "</button>";
                $htmlFormCancelOrder .= "</form>";
            }
            return $htmlFormCancelOrder;
        }
    }
}

if (!function_exists('displayBeforeTags')) {
    function displayBeforeTags($productId)
    {
        $productTags = ProductTag::getTagsByProduct($productId)->get();
        $htmlBeforeTags = "";

        if ($productTags) {
            $htmlBeforeTags .= "<p class='text-muted'>";
            $htmlBeforeTags .= "<span class='font-italic'>" . __('custom.before') . ":&nbsp;</span>";

            $htmlValueHead = "<span>#";
            $htmlValueEnd  = "&nbsp;</span>";
            $htmlBeforeTags .= loopValueProductTags($productTags, $htmlValueHead, $htmlValueEnd);

            $htmlBeforeTags .= "</p>";
            return $htmlBeforeTags;
        }
        return $htmlBeforeTags;
    }
}

if (!function_exists('displayTagsSidebar')) {
    function displayTagsSidebar()
    {
        $productTags = ProductTag::getCount()->get();
        $htmlTagsSidebar = "";

        if ($productTags) {
            $htmlTagsSidebar .= "<div class='brands_products'>";
            $htmlTagsSidebar .= "<div class='brands-name'>";
            $htmlTagsSidebar .= "<h4 class='text-center text-danger'>". __('custom.tags') . "</h4>";

            $htmlValueHead = "<a href='" . route('search_products', ['keyword' => '#']);
            $valueMiddle   = "' class='btn text-primary'>#";
            $htmlValueEnd  = "</a>";

            $htmlTagsSidebar .= loopValueProductTags($productTags, $htmlValueHead, $htmlValueEnd, $valueMiddle);

            $htmlTagsSidebar .= "</div>";
            $htmlTagsSidebar .= "</div>";

            return $htmlTagsSidebar;
        }
        return $htmlTagsSidebar;
    }
}

function loopValueProductTags($productTags, $valueHead, $valueEnd, $valueMiddle = "") {
    $htmlValue = "";
    foreach ($productTags as $tag)
    {
        if ($valueMiddle)
        {
            $tagSlug = $tag->tags()->first()->slug;
            $htmlValue .= $valueHead . $tagSlug . $valueMiddle . getTagName($tag) . $valueEnd;
        }
        else $htmlValue .= $valueHead . getTagName($tag) . $valueEnd;
    }
    return $htmlValue;
}

function getTagName($data)
{
    $vi_name = $data->tags()->first()->vi_name;
    $en_name = $data->tags()->first()->en_name;
    return checkLanguage($en_name, $vi_name);
}

if (!function_exists('checkAction')) {
    function checkAction($action)
    {
        if ($action == 'create') return true;
        return false;
    }
}

if (!function_exists('checkActionForm')) {
    function checkActionForm($action, $tagId)
    {
        if ($action == 'create') return "action=". route('tag.store') ." method=POST" ;
        return "action=". route('tag.update', $tagId) ." method=POST";
    }
}

if (!function_exists('checkActionTagFormDelete')) {
    function checkActionTagFormDelete($action, $tagId)
    {
        $htmlTagFormDelete = "";
        if ($action == 'update') {
            $htmlTagFormDelete .= "<form action='" . route('tag.destroy', $tagId) . "' id='formDeleteTag' method='POST'>";
            $htmlTagFormDelete .= csrf_field();
            $htmlTagFormDelete .= method_field('DELETE');
            $htmlTagFormDelete .= "<button class='btn btn-danger'>";
            $htmlTagFormDelete .= "<i class='far fa-trash-alt'></i> " . __('custom.delete');
            $htmlTagFormDelete .= "</button>";
            $htmlTagFormDelete .= "</form>";

            return $htmlTagFormDelete;
        }
        return $htmlTagFormDelete;
    }
}

if (!function_exists('displayNotifyAdmin')) {
    function displayNotifyAdmin()
    {
        $userAdmin  = User::byRole(UserRole::getKey(0))->first();
        $notifies   = $userAdmin->notifications->sortBy('create_at');
        $htmlNotify = "";

        if ($notifies) {
            foreach ($notifies as $notify) {
                $username = User::findById($notify->data['user_id'])->first()->name;
                $message = __('custom.message_notify_order_product', [
                    'day'      => checkLanguageWithDay($notify->created_at),
                    'username' => $username,
                    'price'    => formatPrice($notify->data['total_money']),
                ]);

                if ($notify->read_at) $htmlNotify .= htmlNotifyRead($message);
                else $htmlNotify .= htmlNotifyUnread($message, $notify->id);
            }
            return $htmlNotify;
        }
        return $htmlNotify;
    }
}

function htmlNotifyRead($message) {
    $htmlNotify  = "<div class='alert alert-secondary' role='alert'>";
    $htmlNotify .= "<h6 class='pt-2 pb-1'>$message</h6>";
    $htmlNotify .= "</div>";
    return $htmlNotify;
}

function htmlNotifyUnread($message, $notifyId) {
    $htmlNotify  = "<div class='alert alert-success' id='notify-unread' role='alert'>";
    $htmlNotify .= "<div class='row'>";
    $htmlNotify .= "<div class='col pt-2 pb-1'><h6>$message</h6></div>";
    $htmlNotify .= "<div class='text-right'>";
    $htmlNotify .= "<button class='btn btn-success btn-mask-as-read' id='mask-as-read' data-id='$notifyId'>";
    $htmlNotify .= __('custom.mark_as_read');
    $htmlNotify .= "</button>";
    $htmlNotify .= "</div>";
    $htmlNotify .= "</div>";
    $htmlNotify .= "</div>";
    return $htmlNotify;
}
