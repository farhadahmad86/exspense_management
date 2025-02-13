
<div class="sidebar">
    <div class="sidebar-wrapper">
        <ul class="nav">
            <!-- First Level Menu Item -->
            @if (Gate::check('Dashboard'))
                <li class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                    <a href="{{ route('home') }}">
                        <i class="tim-icons icon-chart-bar-32"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
            @endif
            <!-- First Level Menu Item with Collapse -->
            @if (Gate::any(['Roles', 'Employee', 'Cash Account', 'Sale Purchase Party', 'Product','purchase invoice']))
                <li>
                    <a data-toggle="collapse" href="#registration" aria-expanded="{{ Request::is('roles*') || Request::is('employee*') || Request::is('cash_account*') || Request::is('party*') || Request::is('product_reg*') || Route::currentRouteName() == 'add_openning' || Route::currentRouteName() == 'add_party' || Request::is('purchase_invoice*') ? 'true' : 'false' }}">
                        <i class="tim-icons icon-credit-card"></i>
                        <span class="nav-link-text">Registration</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse {{ Request::is('roles*') || Request::is('employee*') || Request::is('cash_account*') || Request::is('party*') || Request::is('product_reg*') || Route::currentRouteName() == 'add_openning' || Route::currentRouteName() == 'add_party' || Request::is('purchase_invoice*') ? 'show' : '' }}" id="registration">
                        <ul class="nav pl-4">
                            <!-- Second Level Menu Items -->
                            @if (Gate::any(['role-create', 'role-list']))
                                <li>
                                    <a data-toggle="collapse" href="#roleSubmenu" aria-expanded="{{ Request::is('roles*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Role</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('roles*') ? 'show' : '' }}" id="roleSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'roles.create' ? 'active' : '' }}">
                                                <a href="{{ route('roles.create') }}">
                                                    <p>Create Role</p>
                                                </a>
                                            </li>
                                            <li class="{{ Route::currentRouteName() == 'roles.index' ? 'active' : '' }}">
                                                <a href="{{ route('roles.index') }}">
                                                    <p>Role List</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if (Gate::any(['employee-create', 'employee-list']))
                                <li>
                                    <a data-toggle="collapse" href="#employeeSubmenu" aria-expanded="{{ Request::is('employee*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Employee</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('employee*') ? 'show' : '' }}" id="employeeSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'employee_registration.create' ? 'active' : '' }}">
                                                <a href="{{ route('employee_registration.create') }}">
                                                    <p>Create Employee</p>
                                                </a>
                                            </li>
                                            <li class="{{ Route::currentRouteName() == 'employee_registration.index' ? 'active' : '' }}">
                                                <a href="{{ route('employee_registration.index') }}">
                                                    <p>Employee List</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if (Gate::any(['cash-account-create', 'cash-account-list']))
                                <li>
                                    <a data-toggle="collapse" href="#cashaccountSubmenu" aria-expanded="{{ Request::is('cash_account*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Cash Account</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('cash_account*') ? 'show' : '' }}" id="cashaccountSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'cash_account.create' ? 'active' : '' }}">
                                                <a href="{{ route('cash_account.create') }}">
                                                    <p>Create Cash Account</p>
                                                </a>
                                            </li>
                                            <li class="{{ Route::currentRouteName() == 'cash_account.index' ? 'active' : '' }}">
                                                <a href="{{ route('cash_account.index') }}">
                                                    <p>Cash Account List</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if (Gate::any(['sale-purchase-party-create', 'sale-purchase-party-list']))
                                <li>
                                    <a data-toggle="collapse" href="#salepurchaseSubmenu" aria-expanded="{{ Request::is('party*') || Request::is('add_party') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Sale Purchase Party</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('party*') || Request::is('add_party') ? 'show' : '' }}" id="salepurchaseSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'add_party' ? 'active' : '' }}">
                                                <a href="{{ route('add_party') }}">
                                                    <p>Create Sale Purchase Party</p>
                                                </a>
                                            </li>
                                            <li class="{{ Route::currentRouteName() == 'party_list' ? 'active' : '' }}">
                                                <a href="{{ route('party_list') }}">
                                                    <p>Sale Purchase Party List</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if (Gate::any(['product-registration-create', 'product-registration-list']))
                                <li>
                                    <a data-toggle="collapse" href="#productSubmenu" aria-expanded="{{ Request::is('product_reg*') || Route::currentRouteName() == 'add_openning' ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Product</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('product_reg*') || Route::currentRouteName() == 'add_openning' ? 'show' : '' }}" id="productSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'product_registration.create' ? 'active' : '' }}">
                                                <a href="{{ route('product_registration.create') }}">
                                                    <p>Create Product</p>
                                                </a>
                                            </li>
                                            <li class="{{ Route::currentRouteName() == 'product_registration.index' ? 'active' : '' }}">
                                                <a href="{{ route('product_registration.index') }}">
                                                    <p>Product List</p>
                                                </a>
                                            </li>
                                            <li class="{{ Route::currentRouteName() == 'add_openning' ? 'active' : '' }}">
                                                <a href="{{ route('add_openning') }}">
                                                    <p>Opening Stock</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if (Gate::any(['purchase-invoice-create', 'purchase-invoice-list']))
                                <li>
                                    <a data-toggle="collapse" href="#purchaseinvoiceSubmenu" aria-expanded="{{ Request::is('purchase_invoice*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Purchase Invoice</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('purchase_invoice*') ? 'show' : '' }}" id="purchaseinvoiceSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'purchase_invoice.create' ? 'active' : '' }}">
                                                <a href="{{ route('purchase_invoice.create') }}">
                                                    <p>Create Purchase Invoice</p>
                                                </a>
                                            </li>
                                            <li class="{{ Route::currentRouteName() == 'purchase_invoice.index' ? 'active' : '' }}">
                                                <a href="{{ route('purchase_invoice.index') }}">
                                                    <p>Purchase Invoice List</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

            @if (Gate::any(['product loss', 'product recover', 'Stock movement list','stock-list']))
                <li>
                    <a data-toggle="collapse" href="#stockmovement" aria-expanded="{{ Request::is('product_loss*') || Request::is('product_recover*') || Request::is('opening_stock*') ? 'true' : 'false' }}">
                        <i class="tim-icons icon-credit-card"></i>
                        <span class="nav-link-text">Stock Movement</span>
                        <b class="caret mt-1"></b>
                    </a>
                    <div class="collapse {{ Request::is('product_loss*') || Request::is('product_recover*') || Request::is('opening_stock*') ? 'show' : '' }}" id="stockmovement">
                        <ul class="nav pl-4">
                            @if (Gate::any(['product-loss-create', 'product-loss-list']))
                                <li>
                                    <a data-toggle="collapse" href="#lossSubmenu" aria-expanded="{{ Request::is('product_loss*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Product Loss</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('product_loss*') ? 'show' : '' }}" id="lossSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'product_loss.create' ? 'active' : '' }}">
                                                <a href="{{ route('product_loss.create') }}">
                                                    <p>Create Product Loss</p>
                                                </a>
                                            </li>
                                            <li class="{{ Route::currentRouteName() == 'product_loss.index' ? 'active' : '' }}">
                                                <a href="{{ route('product_loss.index') }}">
                                                    <p>Product Loss List</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if (Gate::any(['product-recover-create', 'product-recover-list']))
                                <li>
                                    <a data-toggle="collapse" href="#recoverSubmenu" aria-expanded="{{ Request::is('product_recover*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Product Recover</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('product_recover*') ? 'show' : '' }}" id="recoverSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'product_recover.create' ? 'active' : '' }}">
                                                <a href="{{ route('product_recover.create') }}">
                                                    <p>Create Product Recover</p>
                                                </a>
                                            </li>
                                            <li class="{{ Route::currentRouteName() == 'product_recover.index' ? 'active' : '' }}">
                                                <a href="{{ route('product_recover.index') }}">
                                                    <p>Product Recover List</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if (Gate::any(['Stock movement list', 'stock-list']))
                                <li>
                                    <a data-toggle="collapse" href="#stockmovementlistSubmenu" aria-expanded="{{ Request::is('opening_stock*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Stock Movement List</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('opening_stock*') ? 'show' : '' }}" id="stockmovementlistSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'opening_stock.index' ? 'active' : '' }}">
                                                <a href="{{ route('opening_stock.index') }}">
                                                    <p>Stock Movement List</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif


            <!-- Invoices Section -->
            @if (Gate::any(['sale invoice', 'cash receipt voucher', 'cash payment voucher', 'cash book']))
                <li>
                    <a data-toggle="collapse" href="#invoices" aria-expanded="{{ Request::is('sale_invoice*') || Request::is('cash_receipt_voucher*') || Request::is('cash_payment_voucher*') || Request::is('cash_book*') ? 'true' : 'false' }}">
                        <i class="tim-icons icon-credit-card"></i>
                        <span class="nav-link-text">Invoices</span>
                        <b class="caret mt-1"></b>
                    </a>
                    <div class="collapse {{ Request::is('sale_invoice*') || Request::is('cash_receipt_voucher*') || Request::is('cash_payment_voucher*') || Request::is('cash_book*') ? 'show' : '' }}" id="invoices">
                        <ul class="nav pl-4">
                            @if (Gate::any(['sale-invoice-create', 'sale-invoice-list']))
                                <li>
                                    <a data-toggle="collapse" href="#saleinvoiceSubmenu" aria-expanded="{{ Request::is('sale_invoice*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Sale Invoice</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('sale_invoice*') ? 'show' : '' }}" id="saleinvoiceSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'sale_invoice.create' ? 'active' : '' }}">
                                                <a href="{{ route('sale_invoice.create') }}">
                                                    <p>Create Sale Invoice</p>
                                                </a>
                                            </li>
                                            <li class="{{ Route::currentRouteName() == 'sale_invoice.index' ? 'active' : '' }}">
                                                <a href="{{ route('sale_invoice.index') }}">
                                                    <p>Sale Invoice List</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if (Gate::any(['cash-receipt-voucher-create', 'cash-receipt-voucher-list']))
                                <li>
                                    <a data-toggle="collapse" href="#cashreceiptvoucherSubmenu" aria-expanded="{{ Request::is('cash_receipt_voucher*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Cash Receipt Voucher</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('cash_receipt_voucher*') ? 'show' : '' }}" id="cashreceiptvoucherSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'cash_receipt_voucher.create' ? 'active' : '' }}">
                                                <a href="{{ route('cash_receipt_voucher.create') }}">
                                                    <p>Create Cash Receipt Voucher</p>
                                                </a>
                                            </li>
                                            <li class="{{ Route::currentRouteName() == 'cash_receipt_voucher.index' ? 'active' : '' }}">
                                                <a href="{{ route('cash_receipt_voucher.index') }}">
                                                    <p>Cash Receipt Voucher List</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if (Gate::any(['cash-payment-voucher-create', 'cash-payment-voucher-list']))
                                <li>
                                    <a data-toggle="collapse" href="#cashpaymentvoucherSubmenu" aria-expanded="{{ Request::is('cash_payment_voucher*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Cash Payment Voucher</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('cash_payment_voucher*') ? 'show' : '' }}" id="cashpaymentvoucherSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'cash_payment_voucher.create' ? 'active' : '' }}">
                                                <a href="{{ route('cash_payment_voucher.create') }}">
                                                    <p>Create Cash Payment Voucher</p>
                                                </a>
                                            </li>
                                            <li class="{{ Route::currentRouteName() == 'cash_payment_voucher.index' ? 'active' : '' }}">
                                                <a href="{{ route('cash_payment_voucher.index') }}">
                                                    <p>Cash Payment Voucher List</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if (Gate::any(['cash-book-list']))
                                <li>
                                    <a data-toggle="collapse" href="#cashbook" aria-expanded="{{ Request::is('cash_book*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Cash Book</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('cash_book*') ? 'show' : '' }}" id="cashbook">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'cash_book_list' ? 'active' : '' }}">
                                                <a href="{{ route('cash_book_list') }}">
                                                    <p>Cash Book</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

            <!-- Reports Section -->
            @if (Gate::any(['Reports', 'Stock Report', 'stock-report']))
                <li>
                    <a data-toggle="collapse" href="#reports" aria-expanded="{{ Request::is('stock_report*') || Request::is('Profit_Report*') ? 'true' : 'false' }}">
                        <i class="tim-icons icon-chart-bar-32"></i>
                        <span class="nav-link-text">Reports</span>
                        <b class="caret mt-1"></b>
                    </a>
                    <div class="collapse {{ Request::is('stock_report*') || Request::is('Profit_Report*') ? 'show' : '' }}" id="reports">
                        <ul class="nav pl-4">
                            @if (Gate::any(['Stock Report', 'stock-report']))
                                <li>
                                    <a data-toggle="collapse" href="#stockreportSubmenu" aria-expanded="{{ Request::is('stock_report*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Stock Report</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('stock_report*') ? 'show' : '' }}" id="stockreportSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'stock_report' ? 'active' : '' }}">
                                                <a href="{{ route('stock_report') }}">
                                                    <p>Stock Report</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if (Gate::any(['Profit Report', 'profit-report']))
                                <li>
                                    <a data-toggle="collapse" href="#profitreportsSubmenu" aria-expanded="{{ Request::is('Profit_Report*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Profit Report</span>
                                        <b class="caret mt-1"></b>
                                    </a>
                                    <div class="collapse {{ Request::is('Profit_Report*') ? 'show' : '' }}" id="profitreportsSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'Profit_Report' ? 'active' : '' }}">
                                                <a href="{{ route('Profit_Report') }}">
                                                    <p>Profit Report</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->id == 1)
                <li class="{{ Request::is('add_company') || Request::is('company_list') ? 'active' : '' }}">
                    <a data-toggle="collapse"
                       href="#company" aria-expanded="{{ Request::is('add_company') || Request::is('company_list') ? 'true' : 'false' }}">
                        <i class="tim-icons icon-credit-card"></i>
                        <span class="nav-link-text">Company</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse {{ Request::is('add_company') || Request::is('company_list') ? 'show' : '' }}" id="company">
                        <ul class="nav pl-4">
                            <!-- Second Level Menu Item -->
                            <li class="{{ Request::is('add_company') || Request::is('company_list') ? 'active' : '' }}">
                                <a data-toggle="collapse"
                                   href="#companysSubmenu" aria-expanded="{{ Request::is('add_company*') || Request::is('company_list*') ? 'true' : 'false' }}">
                                    <span class="nav-link-text">Company</span>
                                    <b class="caret mt-1"></b>
                                </a>

                                <div class="collapse {{ Request::is('add_company') || Request::is('company_list') ? 'show' : '' }}" id="companysSubmenu">
                                    <ul class="nav pl-4">
                                        <li class="{{ Route::currentRouteName() == 'add_company' ? 'active' : '' }}">
                                            <a href="{{ route('add_company') }}">
                                                <p>Create Company</p>
                                            </a>
                                        </li>
                                        <li class="{{ Route::currentRouteName() == 'company_list' ? 'active' : '' }}">
                                            <a href="{{ route('company_list') }}">
                                                <p>Company List</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if (Gate::any(['Company Profile', 'Profile', 'Update-Profile']))
                <li>
                    <a data-toggle="collapse"
                       href="#companyprofile" aria-expanded="{{ Request::is('company_profile*') ? 'true' : 'false' }}">
                        <i class="tim-icons icon-credit-card"></i>
                        <span class="nav-link-text">Company Profile</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse {{ Request::is('company_profile*') ? 'show' : '' }}" id="companyprofile">
                        <ul class="nav pl-4">
                            @if(Gate::any(['Profile', 'Update-Profile']))
                                <!-- Second Level Menu Item -->
                                <li>
                                    <a data-toggle="collapse"
                                       href="#profileSubmenu" aria-expanded="{{ Request::is('company_profile*') ? 'true' : 'false' }}">
                                        <span class="nav-link-text">Profile</span>
                                        <b class="caret mt-1"></b>
                                    </a>

                                    <div class="collapse {{ Request::is('company_profile*') ? 'show' : '' }}" id="profileSubmenu">
                                        <ul class="nav pl-4">
                                            <li class="{{ Route::currentRouteName() == 'company_profile' ? 'active' : '' }}">
                                                <a href="{{ route('company_profile') }}">
                                                    <p>Update Profile</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

        </ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all menu items with collapse
        var collapsibleItems = document.querySelectorAll('.nav [data-toggle="collapse"]');

        collapsibleItems.forEach(function(item) {
            item.addEventListener('click', function() {
                var targetId = item.getAttribute('href').substring(1); // Get the target ID

                // Check and close relevant menus based on the target ID
                if (targetId === 'stockmovement') {
                    closeMenu('registration');
                    closeMenu('invoices');
                    closeMenu('reports');
                    closeMenu('companyprofile');
                } else if (targetId === 'registration') {
                    closeMenu('stockmovement');
                    closeMenu('invoices');
                    closeMenu('reports');
                    closeMenu('companyprofile');
                } else if (targetId === 'invoices') {
                    closeMenu('registration');
                    closeMenu('stockmovement');
                    closeMenu('reports');
                    closeMenu('companyprofile');
                } else if (targetId === 'reports') {
                    closeMenu('registration');
                    closeMenu('stockmovement');
                    closeMenu('invoices');
                    closeMenu('companyprofile');
                } else if (targetId === 'companyprofile') {
                    closeMenu('registration');
                    closeMenu('stockmovement');
                    closeMenu('invoices');
                    closeMenu('reports');
                }
            });
        });

        function closeMenu(menuId) {
            var menuElement = document.getElementById(menuId);
            if (menuElement && menuElement.classList.contains('show')) {
                $(menuElement).collapse('hide'); // Use jQuery collapse method to hide
            }
        }
    });
</script>

