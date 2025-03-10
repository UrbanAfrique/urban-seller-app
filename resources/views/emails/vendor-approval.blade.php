@include('emails.components.mail-header',['mailHeading'=>$mailHeading])
<main style="padding: 10px;text-align: center;">
    <p>{!! $mailDescription !!}</p>
    @if($type==\App\Enum\ApprovedStatusEnum::APPROVED)
        <a style="margin: 0 auto;background-color: #4374e0;padding: 10px;color: white;border-radius: 10px;text-decoration: none;"  target="_blank" href="{{ $loginUrl }}">
            {{ trans('general.dashboard') }}
        </a>
    @endif
</main>
@include('emails.components.mail-footer')
