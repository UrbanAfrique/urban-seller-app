@extends('layouts.guest-proxy')
@section('content')
    {!! Form::open(['url'=>route('proxy.payout.store'),'enctype' => 'multipart/form-data','id'=>'subscribe-form']) !!}
    {!! Form::hidden('customerId',$customerId) !!}
    {!! Form::hidden('planId',$planId) !!}
    {!! Form::hidden('paymentMethod',null,['id'=>'paymentMethod']) !!}
    <div class="w3-row-padding w3-x-center-aligned">
         <div class="w3-col s7">
            @include('components.proxy-header',['type'=>'payout'])
            <div class="w3-row-padding">
                <div class='w3-col s-12'>
                    <div id="card-element"></div>
                </div>
                <div class='w3-col s-12'>
                    <div id="card-errors"></div>
                </div>
                <div class="w3-col s12 w3-center">
                    {!! Form::submit('Subscribed', [
                    'class' => 'w3-btn w3-black',
                    'id' => 'card-button',
                    'data-secret' => $intent->client_secret,
                    ]) !!}
                </div>
            </div>
         </div>
    </div>
    {!! Form::close() !!}
@endsection
@section('innerScriptFiles')
<script src="https://js.stripe.com/v3/"></script>
@endsection
@section('pageScript')
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    var card = elements.create('card', {
        hidePostalCode: true,
        style: style
    });
    card.mount('#card-element');
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        displayError.textContent = event.error ? event.error.message : '';
    });

    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', async (e) => {
        e.preventDefault();
        console.log("attempting");
        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: card
                }
            }
        );
        if (error) {
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
        } else {
            console.log(setupIntent.payment_method);
            $("#paymentMethod").val(setupIntent.payment_method);
            $("#subscribe-form").submit();
        }
        return false;
    });
</script>
@endsection