


@extends('layouts.app')

@section('title', 'Plot Booking')

@section('content')
<section class="booking-form" style="max-width:1000px;margin:40px auto;padding:20px;">

    <h1 style="margin-bottom:6px;">Plot Booking</h1>
    <p style="margin-bottom:18px;color:#666;">Fill customer details and confirm booking.</p>

    @if(session('error'))
        <div style="background:#ffe5e5;padding:12px;border-radius:8px;margin-bottom:12px;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background:#fff3cd;padding:12px;border-radius:8px;margin-bottom:12px;">
            @foreach ($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Plot Summary Card --}}
    <div style="background:#fff;border:1px solid #eee;border-radius:12px;padding:14px;margin-bottom:18px;">
        <h3 style="margin:0 0 10px;">Plot Details</h3>
        <div style="display:flex;gap:18px;flex-wrap:wrap;color:#333;">
            <div><b>Plot No:</b> {{ str_pad($plot->plot_no, 2, '0', STR_PAD_LEFT) }}</div>

            <div><b>Sq. Yards:</b> {{ $plot->sq_yards }}</div>
            <div><b>Gadhulu:</b> {{ number_format($plot->gadhulu, 2) }}</div>
            <div><b>Facing:</b> {{ $plot->facing }}</div>
            <div><b>Road Width:</b> {{ $plot->road_width }} ft</div>
        </div>
    </div>

    <form method="POST" action="{{ route('plot.booking.store', $plot->id) }}" enctype="multipart/form-data"
          style="background:#fff;border:1px solid #eee;border-radius:14px;padding:18px;">
        @csrf

        <h3 style="margin-top:0;">Customer Information</h3>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <label>Customer Name *</label>
                <input name="customer_name" value="{{ old('customer_name') }}" required
                       style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
            </div>
            <div>
                <label>Father Name</label>
                <input name="father_name" value="{{ old('father_name') }}"
                       style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
            </div>

            <div>
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                       style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
            </div>

            <div>
                <label>Contact Number *</label>
                <input name="contact_number" value="{{ old('contact_number') }}" required
                       style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
            </div>
            <div>
                <label>Alternative Contact Number</label>
                <input name="alternate_contact_number" value="{{ old('alternate_contact_number') }}"
                       style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
            </div>
        </div>

        <hr style="margin:18px 0;border:none;border-top:1px solid #eee;">

        <h3>Address</h3>
            
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <label>Permanent Address *</label>
                <textarea name="permanent_address" required
                          style="width:100%;min-height:90px;padding:10px;border:1px solid #ddd;border-radius:10px;">{{ old('permanent_address') }}</textarea>
            </div>
            <div>
                <label>Temporary Address</label>
                <textarea id="tempAddress" name="temporary_address"
                          style="width:100%;min-height:90px;padding:10px;border:1px solid #ddd;border-radius:10px;">{{ old('temporary_address') }}</textarea>
                <div style="margin-top:8px;">
                    <!-- <label style="display:flex;gap:8px;align-items:center;">
                        <input type="checkbox" id="sameAddress" name="same_address" value="1" {{ old('same_address') ? 'checked' : '' }}>
                        Temporary address same as permanent
                    </label> -->
                </div>
            </div>
        </div>

        <hr style="margin:18px 0;border:none;border-top:1px solid #eee;">

        <h3>Payment</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <label>Advance Amount (₹50,000 to ₹1,00,000) *</label>
                <input type="number" name="advance_amount" value="{{ old('advance_amount') }}" required min="50000" max="100000"
                       style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
            </div>
            <div>
                <label>Payment Method *</label>
                <select name="payment_method" required
                        style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
                    <option value="">Select</option>
                    <option value="upi" {{ old('payment_method')=='upi'?'selected':'' }}>UPI</option>
                    <option value="cash" {{ old('payment_method')=='offline'?'selected':'' }}>CASH</option>
                </select>
            </div>
        </div>

        <hr style="margin:18px 0;border:none;border-top:1px solid #eee;">

        <h3>Live Photo Capture</h3>

        {{-- Hidden base64 for captured photo --}}
        <input type="hidden" name="captured_photo" id="captured_photo">

        <div style="display:flex;gap:18px;flex-wrap:wrap;align-items:flex-start;">
            <div>
                <video id="video" autoplay playsinline style="width:320px;border-radius:12px;border:1px solid #ddd;background:#000;"></video>
                <div style="margin-top:10px;display:flex;gap:10px;">
                    <button type="button" id="startCam" style="padding:10px 12px;border-radius:10px;border:1px solid #ddd;cursor:pointer;">Start Camera</button>
                    <button type="button" id="capture" style="padding:10px 12px;border-radius:10px;border:1px solid #ddd;cursor:pointer;">Capture</button>
                </div>
                <p style="color:#777;margin-top:8px;font-size:13px;">If camera not allowed, upload photo below.</p>
            </div>

            <div>
                <canvas id="canvas" style="display:none;"></canvas>
                <img id="preview" style="width:320px;border-radius:12px;border:1px solid #ddd;display:none;">
                <div style="margin-top:10px;">
                    <label>Upload Photo (Optional fallback)</label>
                    <input type="file" name="live_photo" accept="image/*"
                           style="display:block;margin-top:8px;">
                </div>
            </div>
        </div>

        @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
            <hr style="margin:18px 0;border:none;border-top:1px solid #eee;">
            <h3>Admin Email Note (Editable)</h3>
            <textarea name="admin_email_note"
                      style="width:100%;min-height:90px;padding:10px;border:1px solid #ddd;border-radius:10px;">{{ old('admin_email_note') }}</textarea>
        @endif

        <hr style="margin:18px 0;border:none;border-top:1px solid #eee;">

        <div style="background:#f7f9ff;border:1px solid #e6ebff;padding:14px;border-radius:12px;">
            <h4 style="margin:0 0 6px;">Policies</h4>
            <div style="color:#444;font-size:14px;line-height:1.6;">
                • Advance payment is <b>non-refundable</b>.<br>
                • From Date of Booking Agreement must be excute within <b>7 days</b> from booking date.<br>
                • From Date of Agreement to  Date of Sale should done or before <b> 45 days </b>

            </div>
        </div>

        <div style="margin-top:18px;display:flex;gap:12px;">
            <button type="submit"
                    style="padding:12px 18px;border:none;border-radius:12px;background:#0A1735;color:#fff;font-weight:700;cursor:pointer;">
                Confirm Booking
            </button>
            <a href="{{ route('plots.index') }}"
               style="padding:12px 18px;border-radius:12px;border:1px solid #ddd;text-decoration:none;color:#222;">
                Back
            </a>
        </div>

    </form>
</section>

<script>
const sameAddress = document.getElementById('sameAddress');
const tempAddress = document.getElementById('tempAddress');

if (sameAddress) {
  sameAddress.addEventListener('change', () => {
    if (sameAddress.checked) {
      tempAddress.value = document.querySelector('textarea[name="permanent_address"]').value;
      tempAddress.setAttribute('readonly', 'readonly');
    } else {
      tempAddress.removeAttribute('readonly');
    }
  });
}

let stream;
document.getElementById('startCam').addEventListener('click', async () => {
  try {
    stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
    document.getElementById('video').srcObject = stream;
  } catch (e) {
    alert("Camera permission denied or not available. Please upload photo instead.");
  }
});

document.getElementById('capture').addEventListener('click', () => {
  const video = document.getElementById('video');
  const canvas = document.getElementById('canvas');
  const preview = document.getElementById('preview');

  if (!video.srcObject) {
    alert("Start camera first.");
    return;
  }

  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  const ctx = canvas.getContext('2d');
  ctx.drawImage(video, 0, 0);

  const dataUrl = canvas.toDataURL('image/png');
  document.getElementById('captured_photo').value = dataUrl;

  preview.src = dataUrl;
  preview.style.display = 'block';
});
</script>
@endsection
