        <!-- Top App Bar -->
        <header class="px-3 px-md-4 d-flex align-items-center justify-content-between flex-shrink-0 position-relative" style="height: 5rem; z-index: 50;">
            <div class="top-bubble-bar w-100 d-flex align-items-center justify-content-between">
                
                <!-- Left Side: Time and Date -->
                <div class="d-flex align-items-center gap-2 text-muted font-weight-bold px-2 px-md-3">
                    <i class="far fa-calendar-alt text-lg"></i>
                    <span id="topDateChip" class="text-sm"></span>
                </div>

                <!-- Right Side Actions -->
                <div class="d-flex align-items-center gap-2 gap-md-3 pr-1 position-relative" id="notificationContainer">
                    
                    <!-- Notifications -->
                    <button id="notificationBtn" class="bubble-btn" title="Notifications" onclick="toggleNotifications(event)">
                        <i class="fas fa-bell"></i>
                        <span class="bubble-badge"></span>
                    </button>
                    
                    <!-- Notification Popup -->
                    <div id="notificationPopup" class="notification-popup">
                        <div class="notification-header d-flex justify-content-between align-items-center">
                            <h6 class="font-weight-bold mb-0 text-dark">Notifications</h6>
                            <span class="badge badge-primary badge-pill">3 New</span>
                        </div>
                        <div class="overflow-auto" style="max-height: 320px;">
                            <div class="notification-item">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                    <i class="fas fa-briefcase small"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-weight-bold text-dark mb-0">New job confirmed</p>
                                    <p class="text-xs text-muted mb-0">Job #4092 has been approved.</p>
                                    <p class="text-muted mb-0" style="font-size: 10px;">2 mins ago</p>
                                </div>
                            </div>
                            <div class="notification-item border-bottom-0">
                                <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                    <i class="fas fa-exclamation-circle small"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-weight-bold text-dark mb-0">Low stock alert</p>
                                    <p class="text-xs text-muted mb-0">Cyan Ink is running critically low.</p>
                                    <p class="text-muted mb-0" style="font-size: 10px;">1 hour ago</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 text-center border-top bg-light" style="border-bottom-left-radius: 18px; border-bottom-right-radius: 18px;">
                            <a href="#" class="text-xs font-weight-bold text-primary">View All</a>
                        </div>
                    </div>
                    
                    <div class="bubble-divider"></div>
                    
                    <!-- Avatar -->
                    <div class="bubble-avatar" title="Super Administrator" onclick="toggleProfile(event)">SA</div>

                    <!-- Profile Popup -->
                    <div id="profilePopup" class="profile-popup">
                        <div class="p-3 border-bottom d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary-900 text-white d-flex align-items-center justify-content-center font-weight-bold text-sm flex-shrink-0" style="width: 40px; height: 40px;">
                                SA
                            </div>
                            <div class="overflow-hidden">
                                <p class="font-weight-bold text-muted text-uppercase mb-0" style="font-size: 10px;">Logged in as</p>
                                <p class="text-sm font-weight-bold text-dark mb-0 text-truncate">Super Administrator</p>
                            </div>
                        </div>
                        <div class="p-2 d-flex flex-column gap-1">
                            <a href="#" class="d-flex align-items-center gap-2 px-3 py-2 text-sm text-dark rounded-xl nav-item-custom">
                                <i class="fas fa-user text-muted"></i> My Profile
                            </a>
                            <a href="#" class="d-flex align-items-center gap-2 px-3 py-2 text-sm text-dark rounded-xl nav-item-custom">
                                <i class="fas fa-cog text-muted"></i> Settings
                            </a>
                            <div class="border-top my-1"></div>
                            <a href="#" class="d-flex align-items-center gap-2 px-3 py-2 text-sm text-danger rounded-xl hover-lift-sm">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
        </header>