<div class="row">

    <!-- OBJETIVOS -->
    @include('pages.home.team.widgets.first-row.goals')

    <!-- PAYMENTS -->
    @include('pages.home.team.widgets.first-row.payments-today')
    @include('pages.home.team.widgets.first-row.payments-this-month')
    @include('pages.home.team.widgets.first-row.payments-this-year')
    @include('pages.home.team.widgets.first-row.payments-total')
        
    <!--PROJECTS PENDING-->
    @include('pages.home.team.widgets.first-row.projects-pending')

    <!--PROJECTS COMPLETED-->
    @include('pages.home.team.widgets.first-row.tasks-new')

    <!--INVOICES DUE-->
    @include('pages.home.team.widgets.first-row.tasks-inprogress')

    <!--INVOICES OVERDUE-->
    @include('pages.home.team.widgets.first-row.tasks-feedback')
</div>