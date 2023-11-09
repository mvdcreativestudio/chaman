<div class="container d-flex col-12">
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">{{ $payload['leads']['total'] }}</h2>
                        <h6 class="text-muted m-b-0">Leads Totales</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-info ti-user"></i>
                    </div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-info w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">{{ $payload['leads']['this_week'] }}</h2>
                        <h6 class="text-muted m-b-0">Leads esta semana</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-info ti-angle-up"></i>
                    </div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-info w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">{{ $payload['leads']['today'] }}</h2>
                        <h6 class="text-muted m-b-0">Leads hoy</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-info ti-angle-double-up"></i>
                    </div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-info w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">{{ $payload['leads']['converted'] }}</h2>
                        <h6 class="text-muted m-b-0">Leads convertidos</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-info ti-check"></i>
                    </div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-info w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>
