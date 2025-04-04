<div>
@if(auth()->user()->role === 'super_admin')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6 mt-3">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalAthletes }}</h3> 
                        </div>
                        <div class="descriptiom">
                            <p>Total Athletes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-biking"></i> <!-- Corrected icon -->
                        </div>
                        <a href="{{  url('/athletes')  }}" class="small-box-footer">
                            View All <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div> 
@endif
</div> 