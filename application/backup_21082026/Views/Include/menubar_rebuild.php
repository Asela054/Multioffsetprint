    <?php 
    $controllermenu=$this->router->fetch_class();
    $functionmenu=uri_string();
    $functionmenu2=$this->router->fetch_method();

    $menuprivilegearray = $menuaccess;
    $permissionallowed = array();
    $addcheck = 0;
    $editcheck = 0;
    $statuscheck = 0;
    $deletecheck = 0;
    $approvecheck = 0;
    $checkstatus = 0;
    $accountstatus = 0;

    foreach($menuprivilegearray as $row){
        if($row->module==$functionmenu2){
            if($row->permission_type==1){$addcheck=1;}
            if($row->permission_type==2){$editcheck=1;}
            if($row->permission_type==3){$statuscheck=1;}
            if($row->permission_type==4){$deletecheck=1;}
            if($row->permission_type==5){$approvecheck=1;}
            if($row->permission_type==6){$checkstatus=1;}
            if($row->permission_type==7){$accountstatus=1;}
        }

        if($row->module==$functionmenu){
            if($row->permission_type==1){$addcheck=1;}
            if($row->permission_type==2){$editcheck=1;}
            if($row->permission_type==3){$statuscheck=1;}
            if($row->permission_type==4){$deletecheck=1;}
            if($row->permission_type==5){$approvecheck=1;}
            if($row->permission_type==6){$checkstatus=1;}
            if($row->permission_type==7){$accountstatus=1;}
        }
        
        array_push($permissionallowed, $row->module);
    }

    $permissionallowed = array_unique($permissionallowed);
    ?>
    <textarea class="d-none" id="actiontext"><?php if($this->session->flashdata('msg')) {echo $this->session->flashdata('msg');} ?></textarea>
    <!-- Sidebar Container -->
    <aside id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 position-relative sidebar-transition h-100">
        <!-- Sidebar Toggle Button -->
        <button id="sidebarToggle" class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle sidebar">
            <i class="fas fa-caret-left small"></i>
        </button>
        
        <!-- Inner Sidebar Card -->
        <div class="glass-card rounded-3xl d-flex flex-column h-100 overflow-hidden position-relative">
            
            <!-- Logo Section -->
            <div class="p-4 pb-2 logo-wrapper">
                <div class="d-flex align-items-center gap-3 logo-section" onclick="toggleSidebar()" title="Toggle sidebar">
                    <div class="bg-primary-900 text-white rounded-xl shadow-sm d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                        <i class="fas fa-print text-lg"></i>
                    </div>
                    <h1 class="logo-text h6 font-weight-bold text-dark mb-0 tracking-tight" style="line-height: 1.1;">Multi Offset<br>Printers <span style="font-size: 10px; font-weight: normal;">(Pvt) Ltd</span></h1>
                </div>
            </div>

            <!-- Scrollable Navigation Area -->
            <div class="flex-grow-1 overflow-auto px-3 py-3 mt-2 nav-scroll-area">
                <div class="text-xs font-weight-bold text-muted text-uppercase tracking-wider mb-3 px-2 section-header">Core Modules</div>
                
                <nav class="d-flex flex-column gap-1">
                    <!-- Dashboard -->
                    <a href="#" data-page="dashboard" class="nav-item-custom nav-active d-flex align-items-center justify-content-between px-3 py-2 rounded-2xl font-weight-bold">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-desktop text-lg"></i>
                            <span>Dashboard</span>
                        </div>
                    </a>

                    <!-- Expandable Item -->
                    <?php if(in_array("Location", $permissionallowed) || in_array("Measurements", $permissionallowed) || in_array("Servicetype", $permissionallowed) || in_array("Taxcontrol", $permissionallowed) || in_array("Charges", $permissionallowed) || in_array("Chargesdetail", $permissionallowed) || in_array("Serviceitemlist", $permissionallowed) || in_array("Expences", $permissionallowed) || in_array("Uomconversions", $permissionallowed)) { ?>
                    <div class="d-flex flex-column gap-1">
                        <button onclick="toggleMasterSubmenu(this)" class="nav-item-custom w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-2xl font-weight-bold border-0 bg-transparent text-left" style="outline: none;">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-list text-lg"></i>
                                <span>Master Information</span>
                            </div>
                            <i id="caret-master" class="fas fa-caret-down text-muted transition-transform"></i>
                        </button>
                        
                        <div id="submenu-master" class="d-none flex-column gap-1 pl-4 pr-1 pt-1 pb-2">
                            <?php if(in_array("Location", $permissionallowed)){ ?>
                            <a href="<?php echo base_url().'Location'; ?>" class="nav-item-custom d-flex align-items-center px-3 py-2 rounded-2xl text-muted font-weight-bold">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary" style="width: 6px; height: 6px;"></div>
                                    <span class="text-sm">Location</span>
                                </div>
                            </a>
                            <?php } if(in_array("Measurements", $permissionallowed)){ ?>
                            <a href="<?php echo base_url().'Measurements'; ?>" class="nav-item-custom d-flex align-items-center px-3 py-2 rounded-2xl text-muted font-weight-bold">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary" style="width: 6px; height: 6px;"></div>
                                    <span class="text-sm">Measurements</span>
                                </div>
                            </a>
                            <?php } if(in_array("Servicetype", $permissionallowed)){ ?>
                            <a href="<?php echo base_url().'Servicetype'; ?>" class="nav-item-custom d-flex align-items-center px-3 py-2 rounded-2xl text-muted font-weight-bold">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary" style="width: 6px; height: 6px;"></div>
                                    <span class="text-sm">Service Type</span>
                                </div>
                            </a>
                            <?php } if(in_array("Taxcontrol", $permissionallowed)){ ?>
                            <a href="<?php echo base_url().'Taxcontrol'; ?>" class="nav-item-custom d-flex align-items-center px-3 py-2 rounded-2xl text-muted font-weight-bold">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary" style="width: 6px; height: 6px;"></div>
                                    <span class="text-sm">Measurements</span>
                                </div>
                            </a>
                            <?php } if(in_array("Charges", $permissionallowed)){ ?>
                            <a href="<?php echo base_url().'Charges'; ?>" class="nav-item-custom d-flex align-items-center px-3 py-2 rounded-2xl text-muted font-weight-bold">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary" style="width: 6px; height: 6px;"></div>
                                    <span class="text-sm">Charges Type</span>
                                </div>
                            </a>
                            <?php } if(in_array("Chargesdetail", $permissionallowed)){ ?>
                            <a href="<?php echo base_url().'Chargesdetail'; ?>" class="nav-item-custom d-flex align-items-center px-3 py-2 rounded-2xl text-muted font-weight-bold">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary" style="width: 6px; height: 6px;"></div>
                                    <span class="text-sm">Charges Details</span>
                                </div>
                            </a>
                            <?php } if(in_array("Serviceitemlist", $permissionallowed)){ ?>
                            <a href="<?php echo base_url().'Serviceitemlist'; ?>" class="nav-item-custom d-flex align-items-center px-3 py-2 rounded-2xl text-muted font-weight-bold">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary" style="width: 6px; height: 6px;"></div>
                                    <span class="text-sm">Service Item List</span>
                                </div>
                            </a>
                            <?php } if(in_array("Expences", $permissionallowed)){ ?>
                            <a href="<?php echo base_url().'Expences'; ?>" class="nav-item-custom d-flex align-items-center px-3 py-2 rounded-2xl text-muted font-weight-bold">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary" style="width: 6px; height: 6px;"></div>
                                    <span class="text-sm">Costing Types</span>
                                </div>
                            </a>
                            <?php } if(in_array("Uomconversions", $permissionallowed)){ ?>
                            <a href="<?php echo base_url().'Uomconversions'; ?>" class="nav-item-custom d-flex align-items-center px-3 py-2 rounded-2xl text-muted font-weight-bold">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary" style="width: 6px; height: 6px;"></div>
                                    <span class="text-sm">UOM Conversions</span>
                                </div>
                            </a>
                            <?php } if(in_array("Warehouse", $permissionallowed)){ ?>
                            <a href="<?php echo base_url().'Warehouse'; ?>" class="nav-item-custom d-flex align-items-center px-3 py-2 rounded-2xl text-muted font-weight-bold">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary" style="width: 6px; height: 6px;"></div>
                                    <span class="text-sm">Warehouse</span>
                                </div>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <!-- Regular Items -->
                    <a href="#" class="nav-item-custom d-flex align-items-center justify-content-between px-3 py-2 rounded-2xl font-weight-bold">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-file-alt text-lg"></i>
                            <span>Material Info</span>
                        </div>
                        <i class="fas fa-caret-right text-muted small"></i>
                    </a>

                    <a href="#" class="nav-item-custom d-flex align-items-center justify-content-between px-3 py-2 rounded-2xl font-weight-bold">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-briefcase text-lg"></i>
                            <span>Job Management</span>
                        </div>
                        <i class="fas fa-caret-right text-muted small"></i>
                    </a>

                    <a href="#" class="nav-item-custom d-flex align-items-center justify-content-between px-3 py-2 rounded-2xl font-weight-bold">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-users text-lg"></i>
                            <span>Supplier</span>
                        </div>
                        <i class="fas fa-caret-right text-muted small"></i>
                    </a>

                    <a href="#" class="nav-item-custom d-flex align-items-center justify-content-between px-3 py-2 rounded-2xl font-weight-bold">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-truck text-lg"></i>
                            <span>Purchase Order</span>
                        </div>
                        <i class="fas fa-caret-right text-muted small"></i>
                    </a>

                    <a href="#" class="nav-item-custom d-flex align-items-center justify-content-between px-3 py-2 rounded-2xl font-weight-bold">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span>GRN Section</span>
                        </div>
                        <i class="fas fa-caret-right text-muted small"></i>
                    </a>

                     <a href="#" class="nav-item-custom d-flex align-items-center justify-content-between px-3 py-2 rounded-2xl font-weight-bold">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-warehouse text-lg"></i>
                            <span>Stock Management</span>
                        </div>
                        <i class="fas fa-caret-right text-muted small"></i>
                    </a>
                    
                    <a href="#" class="nav-item-custom d-flex align-items-center justify-content-between px-3 py-2 rounded-2xl font-weight-bold">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-exchange-alt text-lg"></i>
                            <span>Stock Transfer</span>
                        </div>
                    </a>

                    <a href="#" class="nav-item-custom d-flex align-items-center justify-content-between px-3 py-2 rounded-2xl font-weight-bold">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-folder-open text-lg"></i>
                            <span>Internal Item Request</span>
                        </div>
                        <i class="fas fa-caret-right text-muted small"></i>
                    </a>
                </nav>
            </div>

            <!-- User Profile Section -->
            <div class="p-3 bg-white border-top user-profile-wrapper" style="z-index: 10;">
                <div class="bg-light rounded-2xl p-2 d-flex align-items-center gap-2 user-profile-inner">
                    <div class="rounded-circle bg-primary-900 text-white d-flex align-items-center justify-content-center font-weight-bold text-sm flex-shrink-0" style="width: 35px; height: 35px;">
                        SA
                    </div>
                    <div class="overflow-hidden user-details flex-grow-1 pl-1">
                        <p class="text-xs font-weight-bold text-muted text-uppercase mb-0" style="font-size: 10px;">Logged in as</p>
                        <p class="text-sm font-weight-bold text-dark mb-0 text-truncate">Super Administrator</p>
                    </div>
                    <button class="btn btn-sm btn-link text-muted hover-lift-sm user-logout p-1" title="Logout">
                        <i class="fas fa-sign-out-alt text-lg text-danger"></i>
                    </button>
                </div>
            </div>
        </div>
    </aside>