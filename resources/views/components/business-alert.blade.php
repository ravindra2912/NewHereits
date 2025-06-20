<div>
    @if(round(Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse(Auth::user()->getBusinessDetails->subscription_expiry_date))) <= 7)

        <div class="alert alert-danger row">
        @if(auth()->user()->getBusinessDetails->subscription_expiry_date == null)
        <h4 class="col-12"><i class="icon fas fa-ban "></i> Active business plan</h4>
        <div class="col-7">
            <p class="mb-0">Please active your business plan to continue using our service.</p>
        </div>
        <div class="col-5 text-right">
            <a href="{{ route('business.setting.business.plan')}}" class="btn btn-outline-warning">Active now</a>
        </div>
        @else
        <h4 class="col-12"><i class="icon fas fa-ban "></i> Subscription Expire!</h4>
        <div class="col-7">
            <p class="mb-0">We regret to inform you that your business plan expire on {{ get_date(auth()->user()->getBusinessDetails->subscription_expiry_date) }}.</p>
            <p>To continue using our services, please renew your subscription.</p>
        </div>
        <div class="col-5 text-right">
            <a href="{{ route('business.setting.business.plan')}}" class="btn btn-outline-warning">Renew Subscription</a>
        </div>
        @endif
        
</div>
@endif

@if(auth()->user()->getBusinessDetails->status == 'pending')
<div class="alert alert-info">
    <h5><i class="icon fas fa-info-circle"></i> Business under review</h5>
    <p class="mb-0">Please activate your business plan to continue using our services.</p>
</div>
@endif

</div>