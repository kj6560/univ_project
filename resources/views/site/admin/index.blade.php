@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">


    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{asset('admin/assets')}}/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                                    </div>
                                    
                                </div>
                                <span class="fw-semibold d-block mb-1">Total Users</span>
                                <h3 class="card-title mb-2">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{asset('admin/assets')}}/img/icons/unicons/wallet-info.png" alt="Credit Card" class="rounded" />
                                    </div>
                                    
                                </div>
                                <span>Total Events</span>
                                <h3 class="card-title text-nowrap mb-1">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer class="content-footer footer bg-footer-theme">
        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , made with ❤️ by
                <a href="https://univsportatech.com" target="_blank" class="footer-link fw-bolder">Univ Sports</a>
            </div>

        </div>
    </footer>


    <div class="content-backdrop fade"></div>
</div>

</div>

</div>


<div class="layout-overlay layout-menu-toggle"></div>
</div>

@stop