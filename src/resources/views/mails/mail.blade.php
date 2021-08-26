<!DOCTYPE html>
<html>
<head>
  <title>Food and Drinks</title>
</head>
<body>
<p>{{ __('custom.hello', [], $details['locale']) }},</p>
  <br>
  <h2>{{ $details['title'] }}</h2>
  <h4>- {!! $details['body'] !!}</h4>
   @if(!empty($details['orders']))
    <table style="border-color: #666;" cellpadding="10">
      <tr style='background: #eee;'>
        <th>#</th>
        <th>{{ __('custom.product', [], $details['locale']) }}</th>
        <th>{{ __('custom.quantity', [], $details['locale']) }}</th>
        <th>{{ __('custom.price_total', [], $details['locale']) }}</th>
        <th>{{ __('custom.ordered_at', [], $details['locale']) }}</th>
      </tr>
      @foreach($details['orders'] as $order)
        <tr>
          <th>{{ $loop->iteration }}</th>
          <td>{{ $order->products->name }}</td>
          <td>{{ $order->amount_of }}</td>
          <td>{{ formatPrice($order->total_money) }}</td>
          <td>{{ checkLanguageWithDay($order->created_at) }}</td>
        </tr>
      @endforeach
    </table>
  @endif
  <br>
  <p>{{ __('custom.thank_you', [], $details['locale']) }}!</p>
</body>
</html>
