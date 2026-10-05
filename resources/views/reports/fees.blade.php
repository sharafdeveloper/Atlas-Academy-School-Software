@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap');

.fh-page{
    --navy-950:#0A1526; --navy-900:#0F1F35; --navy-800:#16304E;
    --gold-600:#A9812F; --gold-100:#FBF3E1;
    --surface:#F6F7FA; --raised:#fff; --muted:#FAFBFC;
    --border:#E4E7EC; --border-strong:#D6DAE1;
    --text-1:#101828; --text-2:#4B5568; --text-3:#8A93A3;
    --success-bg:#E7F5EE; --success-text:#146C43;
    --info-bg:#EAF1FB; --info-text:#1D4E89; --info-border:#C9DBF2;
    --shadow-xs:0 1px 2px rgba(16,24,40,.04);
    --shadow-sm:0 2px 6px rgba(16,24,40,.05);
    --shadow-md:0 8px 24px rgba(16,24,40,.08);
    font-family:'Inter',-apple-system,'Segoe UI',Arial,sans-serif;
    color:var(--text-1);
    padding:28px;
    -webkit-font-smoothing:antialiased;
}
.fh-page *{box-sizing:border-box}

/* Header */
.fh-header{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;margin-bottom:28px}
.fh-title{font-family:'Playfair Display',Georgia,serif;font-size:26px;font-weight:700;margin:0 0 6px;letter-spacing:-.2px;color:var(--text-1)}
.fh-subtitle{margin:0;font-size:13.5px;color:var(--text-2)}
.fh-btn{display:inline-flex;align-items:center;gap:7px;padding:11px 19px;border-radius:7px;font-size:13.5px;font-weight:600;font-family:inherit;text-decoration:none!important;border:1px solid transparent;cursor:pointer;box-shadow:var(--shadow-xs);transition:.2s}
.fh-btn-primary{background:var(--navy-950);color:#fff!important}
.fh-btn-primary:hover{background:var(--navy-800);transform:translateY(-1px);box-shadow:var(--shadow-sm)}
.fh-btn-light{background:var(--muted);color:var(--text-2)!important;border-color:var(--border-strong)}
.fh-btn-light:hover{background:#eef0f3;color:var(--text-1)!important}
.fh-btn svg{width:16px;height:16px}

/* Stats */
.fh-stats{display:grid;grid-template-columns:repeat(2,1fr);gap:18px;margin-bottom:26px}
.fh-stat{background:var(--raised);border:1px solid var(--border);border-radius:14px;padding:21px;display:flex;justify-content:space-between;align-items:center;box-shadow:var(--shadow-sm);transition:.2s}
.fh-stat:hover{box-shadow:var(--shadow-md);transform:translateY(-1px)}
.fh-stat p{margin:0 0 8px;font-size:12.5px;font-weight:500;color:var(--text-2)}
.fh-stat h2{margin:0;font-family:'Playfair Display',Georgia,serif;font-size:26px;font-weight:700;color:var(--text-1)}
.fh-stat h2.green{color:var(--success-text)}
.fh-stat-icon{width:42px;height:42px;border-radius:10px;background:var(--gold-100);color:var(--gold-600);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.fh-stat-icon svg{width:20px;height:20px}

/* Cards */
.fh-card{background:var(--raised);border:1px solid var(--border);border-radius:14px;box-shadow:var(--shadow-sm);overflow:hidden;margin-bottom:25px}
.fh-card-head{padding:22px 24px;border-bottom:1px solid var(--border)}
.fh-card-head h3{margin:0 0 4px;font-size:16.5px;font-weight:700;color:var(--text-1)}
.fh-card-head p{margin:0;font-size:12.5px;color:var(--text-2)}

/* Filters */
.fh-filter{display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:18px;align-items:end;padding:22px 24px}
.fh-field{display:flex;flex-direction:column;gap:8px;min-width:0}
.fh-field label{font-size:12px;font-weight:600;color:var(--text-2)}
.fh-input{width:100%;height:44px;padding:0 13px;border:1px solid var(--border-strong);border-radius:7px;background:var(--raised);color:var(--text-1);font-size:13px;font-family:inherit;outline:none;transition:.2s}
.fh-input::placeholder{color:var(--text-3)}
.fh-input:hover{border-color:#9ca3af}
.fh-input:focus{border-color:var(--navy-900);box-shadow:0 0 0 3px rgba(15,31,53,.09)}
.fh-actions{display:flex;gap:10px}
.fh-actions .fh-btn{height:44px;padding:0 20px}

/* Table */
.fh-table-wrap{width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}
.fh-table{width:100%;border-collapse:collapse;border-spacing:0}
.fh-table thead{background:var(--muted)}
.fh-table th{text-align:left;padding:14px 20px;font-size:11px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid var(--border);white-space:nowrap}
.fh-table td{padding:16px 20px;font-size:13px;color:var(--text-2);border-bottom:1px solid var(--surface);white-space:nowrap;vertical-align:middle}
.fh-table tbody tr{transition:background .15s}
.fh-table tbody tr:hover{background:var(--muted)}
.fh-table tbody tr:last-child td{border-bottom:none}
.fh-num{color:var(--text-3);font-weight:600}

.fh-student{display:flex;align-items:center;gap:11px}
.fh-avatar{width:38px;height:38px;border-radius:50%;background:var(--navy-950);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0}
.fh-student strong{display:block;font-size:13px;font-weight:600;color:var(--text-1)}
.fh-student span{display:flex;align-items:center;gap:6px;margin-top:3px;font-size:11px;color:var(--text-3)}

.fh-badge{display:inline-block;padding:5px 10px;border-radius:7px;font-size:11.5px;font-weight:600}
.fh-badge-class{background:var(--muted);border:1px solid var(--border);color:var(--text-2)}
.fh-badge-code{background:var(--gold-100);border:1px solid #EBD9A8;color:var(--gold-600);font-size:10.5px;padding:2px 7px}
.fh-badge-by{background:var(--info-bg);border:1px solid var(--info-border);color:var(--info-text);border-radius:999px;font-size:10.5px;font-weight:700;padding:5px 11px}

.fh-amount{font-weight:700;font-size:13.5px;color:var(--success-text)}
.fh-date{color:var(--text-1);font-weight:500}
.fh-time{display:block;font-size:11px;color:var(--text-3);margin-top:3px}

/* Empty */
.fh-empty{text-align:center;padding:60px 20px!important;white-space:normal!important}
.fh-empty h4{margin:0 0 6px;font-size:15px;color:var(--text-1)}
.fh-empty p{margin:0;font-size:13px;color:var(--text-2)}

/* Pagination (Laravel default views) */
.fh-pagination{padding:16px 24px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;font-size:13px;color:var(--text-2)}
.fh-pagination nav{display:flex;flex-wrap:wrap;gap:12px;align-items:center}
.fh-pagination svg{width:16px;height:16px}
.fh-pagination p{margin:0}
.fh-pagination .pagination{display:flex;list-style:none;gap:4px;margin:0;padding:0}
.fh-pagination a,.fh-pagination .page-link,.fh-pagination span[aria-current] span,.fh-pagination span[aria-disabled] span{
    display:inline-flex;align-items:center;justify-content:center;min-width:34px;height:34px;padding:0 10px;
    border:1px solid var(--border);border-radius:7px;color:var(--text-2);text-decoration:none;background:#fff}
.fh-pagination a:hover,.fh-pagination .page-link:hover{background:var(--muted);color:var(--navy-950)}
.fh-pagination .active .page-link,.fh-pagination span[aria-current] span{background:var(--navy-950);border-color:var(--navy-950);color:#fff}
.fh-pagination .disabled .page-link{background:var(--muted);color:var(--text-3)}

/* Responsive */
@media(max-width:1000px){.fh-filter{grid-template-columns:1fr 1fr}.fh-actions{grid-column:1/-1}}
@media(max-width:700px){
    .fh-page{padding:16px}
    .fh-stats,.fh-filter{grid-template-columns:1fr}
    .fh-btn-primary{width:100%;justify-content:center}
}
</style>

<div class="fh-page">

    <!-- Header -->
    <div class="fh-header">
        <div>
            <h1 class="fh-title">Fees History</h1>
            <p class="fh-subtitle">Complete record of all fees collected from students</p>
        </div>
        <a href="{{ route('reports.fees.pdf', request()->query()) }}" class="fh-btn fh-btn-primary" target="_blank">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><path d="M14 3v6h6"/><path d="M12 12v6m0 0-3-3m3 3 3-3"/></svg>
            Print / Download PDF
        </a>
    </div>

    <!-- Stats -->
    <div class="fh-stats">
        <div class="fh-stat">
            <div>
                <p>Total Payments</p>
                <h2>{{ number_format($totalPayments) }}</h2>
            </div>
            <div class="fh-stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 3h16v18l-3-2-3 2-2-2-2 2-3-2-3 2z"/><path d="M8 8h8M8 12h8"/></svg>
            </div>
        </div>
        <div class="fh-stat">
            <div>
                <p>Total Fees Collected</p>
                <h2 class="green">Rs. {{ number_format($totalAmountCollected, 2) }}</h2>
            </div>
            <div class="fh-stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="fh-card">
        <div class="fh-card-head">
            <h3>Filter Payments</h3>
            <p>Search and filter recorded fee payments</p>
        </div>
        <form method="GET" action="{{ route('reports.fees-history') }}" class="fh-filter">
            <div class="fh-field">
                <label>Search Student</label>
                <input type="text" name="search" class="fh-input" placeholder="Search by student name or code..." value="{{ request('search') }}">
            </div>
            <div class="fh-field">
                <label>Month</label>
                <select name="month" class="fh-input">
                    <option value="">All Months</option>
                    @foreach($months as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fh-field">
                <label>Collected By</label>
                <select name="collected_by" class="fh-input">
                    <option value="">Everyone</option>
                    @foreach($collectors as $c)
                        <option value="{{ $c }}" {{ request('collected_by') == $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fh-actions">
                <button type="submit" class="fh-btn fh-btn-primary">Apply</button>
                <a href="{{ route('reports.fees-history') }}" class="fh-btn fh-btn-light">Reset</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="fh-card">
        <div class="fh-card-head">
            <h3>Payment History</h3>
            <p>Every recorded student fee payment</p>
        </div>
        <div class="fh-table-wrap">
            <table class="fh-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Board</th>
                        <th>Fees Collected</th>
                        <th>Date &amp; Time</th>
                        <th>Collected By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $index => $payment)
                        <tr>
                            <td class="fh-num">{{ $payments->firstItem() + $index }}</td>
                            <td>
                                <div class="fh-student">
                                    <div class="fh-avatar">{{ strtoupper(mb_substr($payment->enrolledStudent->name ?? 'N', 0, 1)) }}</div>
                                    <div>
                                        <strong>{{ $payment->enrolledStudent->name ?? 'N/A' }}</strong>
                                        <span>
                                            {{ $payment->fee_month ?? '-' }}
                                            @if(!empty($payment->enrolledStudent->student_code))
                                                <em class="fh-badge fh-badge-code" style="font-style:normal">{{ $payment->enrolledStudent->student_code }}</em>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td><span class="fh-badge fh-badge-class">{{ $payment->enrolledStudent->class ?? '-' }}</span></td>
                            <td>{{ $payment->enrolledStudent->board ?? '-' }}</td>
                            <td><span class="fh-amount">Rs. {{ number_format($payment->amount_received, 2) }}</span></td>
                            <td>
                                <span class="fh-date">{{ $payment->fee_date ?? '-' }}</span>
                                <span class="fh-time">{{ $payment->fee_time ?? '' }}</span>
                            </td>
                            <td><span class="fh-badge fh-badge-by">{{ $payment->collected_by ?? 'System' }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="fh-empty">
                                <h4>No payments found</h4>
                                <p>No fee payments found for the selected filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="fh-pagination">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

</div>
@endsection