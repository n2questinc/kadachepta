



<div class="main-sidebar">
  <!-- Inner sidebar -->
  <div class="sidebar">
  
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">Menu</li>
      <li class="treeview">
              
              <?php
           foreach($allowed_modules->result() as $module){
           echo "<li > <a href='".site_url($module->module_name)."'><i class='".$module->module_icon."'></i><span>". $module->module_desc."</span></a></li>";
                }
         ?>

            </li>
            <li><a href="http://www.kadachepta.com" target="_blank"><i class="fa fa-circle-o text-red"></i> <span>Visit <b>kadachepta.com</b></span></a></li>
<!--
            <li><a href="http://codecanyon.net/user/appteve"><i class="fa fa-circle-o text-yellow"></i> <span>CodeCanyon</span></a></li>
            <li><a href="http://help.appteve.com"><i class="fa fa-circle-o text-aqua"></i> <span>Support</span></a></li>
-->
      
    </ul><!-- /.sidebar-menu -->

  </div><!-- /.sidebar -->
</div><!-- /.main-sidebar -->
      
