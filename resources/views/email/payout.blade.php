<div>
    <!-- We must ship. - Taylor Otwell -->
    <h2>Hello {{ $freelancer_name }},</h2>

    <p>
       Your payment for the gig <strong>{{ $gig_title }}</strong> has been successfully released.
    </p>

    <p>
        <strong>Amount Paid:</strong> ${{ number_format($transaction->amount_usd, 2) }} USD
    </p>

    <p>
        <strong>Converted Amount:</strong> <span class="amount">{{ number_format($amount_xaf, 2) }} XAF</span>
    </p>

    <p>
        Thank you for your work!
    </p>

    <div class="footer">
        &copy; {{ date('Y') }} Your Platform Name. All rights reserved.
    </div>
    
</div>
