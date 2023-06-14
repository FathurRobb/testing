
<div class="sidebar" data-color="azure" data-background-color="white" data-image="{{asset('assets')}}/img/sidebar-1.jpg">
    <div class="logo"><a href="/" class="simple-text logo-normal">
        Testing
      </a></div>
    <div class="sidebar-wrapper">
      <ul class="nav">
        <li class="nav-item {{ (request()->is('/')) ? 'active': ''}}">
          <a class="nav-link" href="/">
            <i class="material-icons">dashboard</i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item {{ (request()->is('kategori')) ? 'active': ''}}">
          <a class="nav-link" href="/kategori">
            <i class="material-icons">category</i>
            <p>Kategori</p>
          </a>
        </li>
        <li class="nav-item {{ (request()->is('coa')) ? 'active': ''}}">
          <a class="nav-link" href="/coa">
            <i class="material-icons">content_paste</i>
            <p>Chart of Account</p>
          </a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="./typography.html">
            <i class="material-icons">account_balance_wallet</i>
            <p>Transaksi</p>
          </a>
        </li>
      </ul>
    </div>
  </div>