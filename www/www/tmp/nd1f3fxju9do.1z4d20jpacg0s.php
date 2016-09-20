      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li<?php if ($MENUACTIVE=='HOME'): ?> class="active"<?php endif; ?>>
          <a href="/">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview<?php if ($MENUACTIVE=='DOMAINS'): ?> active<?php endif; ?>">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Domains</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/domains"><i class="fa fa-circle-o"></i> View</a></li>
            <li><a href="/domains/add"><i class="fa fa-circle-o"></i> Add</a></li>
          </ul>
        </li>

      </ul>