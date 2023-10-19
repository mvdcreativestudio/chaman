<div class="">
     <!--GOALS-->
     @include('pages.home.admin.widgets.first-row.goals')
</div>

<div class="row">
    <!--PAYMENTS TODAY-->
    @include('pages.home.admin.widgets.first-row.payments-today')

    <!--PAYMENTS THIS MONTH-->
    @include('pages.home.admin.widgets.first-row.payments-this-month')

    <!-- PAYMENTS THIS YEAR-->
    @include('pages.home.admin.widgets.first-row.payments-this-year')

    <!-- PAYMENTS ALWAYS-->
    @include('pages.home.admin.widgets.first-row.payments-total')

    <!--FACTURAS POR VENCER-->
    @include('pages.home.admin.widgets.first-row.invoices-current')

    <!--INVOICES DUE-->
    @include('pages.home.admin.widgets.first-row.invoices-due')

    <!--INVOICES OVERDUE-->
    @include('pages.home.admin.widgets.first-row.invoices-overdue')


</div>