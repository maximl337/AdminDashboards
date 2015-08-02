@inject('countries', 'App\Utilities\CountriesUtility')

<form action="/users/payment-settings" method="POST" class="form">
    {!! csrf_field() !!}
    <div class="form-group">
        <label for="">Full Legal Name *</label>
        <input type="text" class="form-control" name="name" id="" value="{{ $user->name }}" required />
    </div>
    <div class="form-group">
        <label for="">Business name *</label>
        <input type="text" class="form-control" name="company_name" id="" value="{{ $user->company_name }}" required />
    </div>
    <div class="form-group">
        <label for="">Phone *</label>
        <input type="text" class="form-control" name="phone" id="phone" value="{{ $user->phone }}" required />
    </div>
    <div class="form-group">
        <label for="">Address 1 *</label>
        <input type="text" class="form-control" name="address_1" id="address_1" value="{{ $user->address_1 }}" required />
    </div>
    <div class="form-group">
        <label for="">Address 2</label>
        <input type="text" class="form-control" name="address_2" id="address_2" value="{{ $user->address_2 }}" />
    </div>
    <div class="form-group">
        <label for="">City *</label>
        <input type="text" class="form-control" name="city" id="city" value="{{ $user->city }}" required />
    </div>
    <div class="form-group">
        <label for="">State/Province *</label>
        <input type="text" class="form-control" name="state" id="state" value="{{ $user->state }}" required />
    </div>
    <div class="form-group">
        <label for="">Postal Code *</label>
        <input type="text" class="form-control" name="zip" id="zip" value="{{ $user->zip }}" required />
    </div>
    <div class="form-group">
        <label for="">Country *</label>.
        <select class="form-control" name="country" required>
            @foreach($countries::all() as $country)
                <option value="{{ $country['code'] }}" {{ $user->country == $country['code'] ? " selected" : "" }}>
                    {{ $country['name'] }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="">Tax Name *</label>
        <input type="text" class="form-control" name="tax_name" id="tax_name" value="{{ $user->tax_name }}" required />
    </div>
    <div class="form-group">
        <label for="">Tax Number *</label>
        <input type="text" class="form-control" name="tax_number" id="tax_number" value="{{ $user->tax_number }}" required />
    </div>
    <div class="form-group">
        <label for="">Business Type *</label>
        <select class="form-control" name="business_type" required>
            <option value="individual" {{ $user->business_type == 'individual' ? " selected" : "" }}>Individual</option>
            <option value="corporation" {{ $user->business_type == 'corporation' ? " selected" : "" }}>Corporation</option>
            <option value="partnership" {{ $user->business_type == 'partnership' ? " selected" : "" }}>Partnership</option>
        </select>
        
    </div>
    <div class="form-group">
        <label for="">Paypal Account Name *</label>
        <input type="text" class="form-control" name="paypal_account" id="paypal_account" value="{{ $user->name }}" required />
    </div>
    <div class="form-group">
        
        <input type="submit" class="btn btn-primary form-control" value="Save" />
    </div>
</form>