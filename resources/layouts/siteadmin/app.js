var App = function() {
    var MediaSize = {
        xl: 1200,
        lg: 992,
        md: 991,
        sm: 576
    };
    var Dom = {
        main: document.querySelector('html, body'),
        id: {
            container: document.querySelector("#container"),
        },
        class: {
            navbar: document.querySelector(".navbar"),
            overlay: document.querySelector('.overlay'),
            search: document.querySelector('.toggle-search'),
            searchOverlay: document.querySelector('.search-overlay'),
            searchForm: document.querySelector('.search-form-control'),
            mainContainer: document.querySelector('.main-container'),
            mainHeader: document.querySelector('.header.navbar')
        }
    }

    var categoryScroll = {
        scrollCat: function() {
            var sidebarWrapper = document.querySelectorAll('.sidebar-wrapper li.active')[0];
            var sidebarWrapperTop = sidebarWrapper.offsetTop - 12;
            setTimeout(() => {
                const scroll = document.querySelector('.menu-categories');
                scroll.scrollTop = sidebarWrapperTop;
            }, 50);
        }
    }

    var toggleFunction = {
        sidebar: function($recentSubmenu) {

            var sidebarCollapseEle = document.querySelectorAll('.sidebarCollapse');

            sidebarCollapseEle.forEach(el => {
                el.addEventListener('click', function (sidebar) {
                    sidebar.preventDefault();
                    let getSidebar = document.querySelector('.sidebar-wrapper');

                    if ($recentSubmenu === true) {
                        if (document.querySelector('.collapse.submenu').classList.contains('show')) {
                            document.querySelector('.submenu.show').classList.add('mini-recent-submenu');
                            getSidebar.querySelector('.collapse.submenu').classList.remove('show');
                            getSidebar.querySelector('.collapse.submenu').classList.remove('show');
                            document.querySelector('.collapse.submenu').parentNode.querySelector('.dropdown-toggle').setAttribute('aria-expanded', 'false');
                        } else {
                            if (Dom.class.mainContainer.classList.contains('sidebar-closed')) {
                                if (document.querySelector('.collapse.submenu').classList.contains('recent-submenu')) {
                                    getSidebar.querySelector('.collapse.submenu.recent-submenu').classList.add('show');
                                    document.querySelector('.collapse.submenu.recent-submenu').parentNode.querySelector('.dropdown-toggle').setAttribute('aria-expanded', 'true');
                                    document.querySelector('.submenu').classList.remove('mini-recent-submenu');
                                } else {
                                    document.querySelector('li.active .submenu').classList.add('recent-submenu');
                                    getSidebar.querySelector('.collapse.submenu.recent-submenu').classList.add('show');
                                    document.querySelector('.collapse.submenu.recent-submenu').parentNode.querySelector('.dropdown-toggle').setAttribute('aria-expanded', 'true');
                                    document.querySelector('.submenu').classList.remove('mini-recent-submenu');
                                }
                            }
                        }
                    }
                    Dom.class.mainContainer.classList.toggle("sidebar-closed");
                    Dom.class.mainHeader.classList.toggle('expand-header');
                    Dom.class.mainContainer.classList.toggle("sbar-open");
                    Dom.class.overlay.classList.toggle('show');
                    Dom.main.classList.toggle('sidebar-noneoverflow');
                });
            });
        },
        onToggleSidebarSubmenu: function() {
            ['mouseenter', 'mouseleave'].forEach(function(e){
                document.querySelector('.sidebar-wrapper').addEventListener(e, function() {
                    if (document.querySelector('body').classList.contains('alt-menu')) {
                        if (document.querySelector('.main-container').classList.contains('sidebar-closed')) {
                            if (e === 'mouseenter') {
                                document.querySelector('li.menu .submenu').classList.remove('show');
                                document.querySelector('li.menu.active .submenu').classList.add('recent-submenu');
                                document.querySelector('li.menu.active').querySelector('.collapse.submenu.recent-submenu').classList.add('show');
                                document.querySelector('.collapse.submenu.recent-submenu').parentNode.querySelector('.dropdown-toggle').setAttribute('aria-expanded', 'true');
                            } else if (e === 'mouseleave') {
                                let getMenuList = document.querySelectorAll('li.menu');
                                getMenuList.forEach(element => {

                                    var submenuShowEle = element.querySelector('.collapse.submenu.show');

                                    if (submenuShowEle) {
                                        submenuShowEle.classList.remove('show');
                                    }

                                    var submenuExpandedToggleEle = element.querySelector('.dropdown-toggle[aria-expanded="true"]');

                                    if (submenuExpandedToggleEle) {
                                        submenuExpandedToggleEle.setAttribute('aria-expanded', 'false');
                                    }
                                    
                                });
                            }
                        }
                    } else {
                        if (document.querySelector('.main-container').classList.contains('sidebar-closed')) {
                            if (e === 'mouseenter') {
                                document.querySelector('li.menu .submenu').classList.remove('show');

                                if (document.querySelector('li.menu.active .submenu')) {
                                    document.querySelector('li.menu.active .submenu').classList.add('recent-submenu');
                                    document.querySelector('li.menu.active').querySelector('.collapse.submenu.recent-submenu').classList.add('show');
                                    document.querySelector('.collapse.submenu.recent-submenu').parentNode.querySelector('.dropdown-toggle').setAttribute('aria-expanded', 'true');
                                }
                                
                            } else if (e === 'mouseleave') {
                                let getMenuList = document.querySelectorAll('li.menu');
                                getMenuList.forEach(element => {

                                    var submenuShowEle = element.querySelector('.collapse.submenu.show');

                                    if (submenuShowEle) {
                                        submenuShowEle.classList.remove('show');
                                    }


                                    var submenuExpandedToggleEle = element.querySelector('.dropdown-toggle[aria-expanded="true"]');

                                    if (submenuExpandedToggleEle) {
                                        submenuExpandedToggleEle.setAttribute('aria-expanded', 'false');
                                    }
                                    
                                });
                            }
                        }
                    }
                    
                });
            });

        },
        offToggleSidebarSubmenu: function () {
            // $('.sidebar-wrapper').off('mouseenter mouseleave');
        },
        overlay: function() {
            document.querySelector('#dismiss, .overlay').addEventListener('click', function () {
                // hide sidebar
                Dom.class.mainContainer.classList.add('sidebar-closed');
                Dom.class.mainContainer.classList.remove('sbar-open');
                // hide overlay
                Dom.class.overlay.classList.remove('show');
                Dom.main.classList.remove('sidebar-noneoverflow');
            });            
        },
        search: function() {

            if (Dom.class.search) {
                
                Dom.class.search.addEventListener('click', function(event) {
                    this.classList.add('show-search');
                    Dom.class.searchOverlay.classList.add('show');
                    document.querySelector('body').classList.add('search-active');
                });
                
                Dom.class.searchOverlay.addEventListener('click', function(event) {
                    this.classList.remove('show');
                    Dom.class.search.classList.remove('show-search');
                    document.querySelector('body').classList.remove('search-active');
                });
                
                document.querySelector('.search-close').addEventListener('click', function(event) {
                    event.stopPropagation();
                    Dom.class.searchOverlay.classList.remove('show');
                    Dom.class.search.classList.remove('show-search');
                    document.querySelector('body').classList.remove('search-active');
                    document.querySelector('.search-form-control').value = ''
                });
            }

        },
        themeToggle: function (layoutName) {

            var togglethemeEl = document.querySelector('.theme-toggle');
            var getBodyEl = document.body;
            
            togglethemeEl.addEventListener('click', function() {
                
                var getLocalStorage = sessionStorage.getItem("theme");
                var parseObj = JSON.parse(getLocalStorage);

                if (parseObj.settings.layout.darkMode) {

                    var getObjectSettings = parseObj.settings.layout;

                    var newParseObject = {...getObjectSettings, darkMode: false};

                    var newObject = { ...parseObj, settings: { layout: newParseObject }}

                    sessionStorage.setItem("theme", JSON.stringify(newObject))
                    
                    var getUpdatedLocalObject = sessionStorage.getItem("theme");
                    var getUpdatedParseObject = JSON.parse(getUpdatedLocalObject);

                    if (!getUpdatedParseObject.settings.layout.darkMode) {
                        document.body.classList.remove('layout-dark')
                        let ifStarterKit = document.body.getAttribute('page') === 'starter-pack' ? true : false;
                        if (ifStarterKit) {
                            document.querySelector('.navbar-logo').setAttribute('src', '../../src/assets/img/logo2.svg')
                        } else {
                            // document.querySelector('.navbar-logo').setAttribute('src', getUpdatedParseObject.settings.layout.logo.lightLogo)
                        }
                    }
                    
                } else {

                    var getObjectSettings = parseObj.settings.layout;

                    var newParseObject = {...getObjectSettings, darkMode: true};

                    var newObject = { ...parseObj, settings: { layout: newParseObject }}

                    sessionStorage.setItem("theme", JSON.stringify(newObject))

                    var getUpdatedLocalObject = sessionStorage.getItem("theme");

                    var getUpdatedParseObject = JSON.parse(getUpdatedLocalObject);

                    if (getUpdatedParseObject.settings.layout.darkMode) {
                        document.body.classList.add('layout-dark');

                        let ifStarterKit = document.body.getAttribute('page') === 'starter-pack' ? true : false;

                        if (ifStarterKit) {
                            document.querySelector('.navbar-logo').setAttribute('src', '../../src/assets/img/logo.svg')
                        } else {
                            // document.querySelector('.navbar-logo').setAttribute('src', getUpdatedParseObject.settings.layout.logo.darkLogo)
                        }

                    }
                }
            })
            
        }
    }

    var inBuiltfunctionality = {
        mainCatActivateScroll: function() {

            if (document.querySelector('.menu-categories')) {
            
                const ps = new PerfectScrollbar('.menu-categories', {
                    wheelSpeed:.5,
                    swipeEasing:!0,
                    minScrollbarLength:40,
                    maxScrollbarLength:300
                });

            }
        },
        notificationScroll: function() {

            if (document.querySelector('.notification-scroll')) {
                const notificationS = new PerfectScrollbar('.notification-scroll', {
                    wheelSpeed:.5,
                    swipeEasing:!0,
                    minScrollbarLength:40,
                    maxScrollbarLength:300
                });
            }
            
        },
        preventScrollBody: function() {
            var nonScrollableElement = document.querySelectorAll('#sidebar, .user-profile-dropdown .dropdown-menu, .notification-dropdown .dropdown-menu,  .language-dropdown .dropdown-menu')

            var preventScrolling = function(e) {
                e = e || window.event;
                if (e.preventDefault)
                    e.preventDefault();
                e.returnValue = false;  

                nonScrollableElement.scrollTop -= e. wheelDeltaY; 
            }

            nonScrollableElement.forEach(preventScroll => {

                preventScroll.addEventListener('mousewheel', preventScrolling);
                preventScroll.addEventListener('DOMMouseScroll', preventScrolling);
                
            });
        },
        searchKeyBind: function() {

            if (Dom.class.search) {
                Mousetrap.bind('ctrl+/', function() {
                    document.body.classList.add('search-active');
                    Dom.class.search.classList.add('show-search');
                    Dom.class.searchOverlay.classList.add('show');
                    Dom.class.searchForm.focus();
                    return false;
                });                
            }
            
        },
        bsTooltip: function() {
            var bsTooltip = document.querySelectorAll('.bs-tooltip')
            for (let index = 0; index < bsTooltip.length; index++) {
                var tooltip = new bootstrap.Tooltip(bsTooltip[index])
            }
        },
        bsPopover: function() {
            var bsPopover = document.querySelectorAll('.bs-popover')
            for (let index = 0; index < bsPopover.length; index++) {
                var popover = new bootstrap.Popover(bsPopover[index])
            }
        },
        onCheckandChangeSidebarActiveClass: function() {
            if (document.body.classList.contains('alt-menu')) {
                document.querySelector('.sidebar-wrapper li.menu.active [aria-expanded="true"]').setAttribute('aria-expanded', 'false');
            }
        },
        MaterialRippleEffect: function() {
            let getAllBtn = document.querySelectorAll('button.btn, a.btn');
            
            getAllBtn.forEach(btn => {
    
                if (!btn.classList.contains('_no--effects')) {
                    btn.classList.add('_effect--ripple');
                }
                
            });
    
            if (document.querySelector('._effect--ripple')) {
                Waves.attach('._effect--ripple', 'waves-light');
                Waves.init();
            }
        },
        autoHideAlerts: function() {
            // Use global configuration if available, otherwise use default
            const config = window.AlertConfig || {};
            const AUTO_HIDE_DURATION = config.AUTO_HIDE_DURATION || 5000; // 5 seconds default
            const ENABLE_AUTO_HIDE = config.ENABLE_AUTO_HIDE !== false; // true by default
            const ADD_CLOSE_BUTTON = config.ADD_CLOSE_BUTTON !== false; // true by default
            const ENABLE_FADE_ANIMATION = config.ENABLE_FADE_ANIMATION !== false; // true by default
            const ALERT_TYPES = config.ALERT_TYPES || ['alert-success', 'alert-danger', 'alert-warning', 'alert-info'];
            
            // Skip if auto-hide is disabled
            if (!ENABLE_AUTO_HIDE) {
                return;
            }
            
            // Find all Bootstrap alerts
            const alerts = document.querySelectorAll('.alert:not(.alert-dismissible)');
            
            alerts.forEach((alert, index) => {
                // Check if this alert type should be auto-hidden
                const shouldAutoHide = ALERT_TYPES.some(type => alert.classList.contains(type));
                if (!shouldAutoHide) {
                    return;
                }
                
                // Add dismissible functionality if not already present
                if (!alert.classList.contains('alert-dismissible')) {
                    alert.classList.add('alert-dismissible');
                    if (ENABLE_FADE_ANIMATION) {
                        alert.classList.add('fade', 'show');
                    }
                    
                    // Add close button if not present and enabled
                    if (ADD_CLOSE_BUTTON && !alert.querySelector('.btn-close')) {
                        const closeButton = document.createElement('button');
                        closeButton.type = 'button';
                        closeButton.className = 'btn-close';
                        closeButton.setAttribute('data-bs-dismiss', 'alert');
                        closeButton.setAttribute('aria-label', 'Close');
                        alert.appendChild(closeButton);
                    }
                }
                
                // Auto-hide after specified duration
                setTimeout(() => {
                    if (alert && alert.parentNode) {
                        // Try Bootstrap 5 Alert API first
                        try {
                            if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                                const bsAlert = new bootstrap.Alert(alert);
                                bsAlert.close();
                            } else {
                                // Fallback: manually hide the alert
                                alert.style.opacity = '0';
                                alert.style.transition = 'opacity 0.5s ease';
                                setTimeout(() => {
                                    if (alert && alert.parentNode) {
                                        alert.parentNode.removeChild(alert);
                                    }
                                }, 500);
                            }
                        } catch (error) {
                            // Fallback: manually hide the alert
                            alert.style.opacity = '0';
                            alert.style.transition = 'opacity 0.5s ease';
                            setTimeout(() => {
                                if (alert && alert.parentNode) {
                                    alert.parentNode.removeChild(alert);
                                }
                            }, 500);
                        }
                    }
                }, AUTO_HIDE_DURATION);
            });
            
            // Also handle alerts that are added dynamically via AJAX
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) { // Element node
                            // Check if the added node is an alert
                            if (node.classList && node.classList.contains('alert') && !node.classList.contains('alert-dismissible')) {
                                const shouldAutoHide = ALERT_TYPES.some(type => node.classList.contains(type));
                                if (shouldAutoHide) {
                                    node.classList.add('alert-dismissible');
                                    if (ENABLE_FADE_ANIMATION) {
                                        node.classList.add('fade', 'show');
                                    }
                                    
                                    // Add close button
                                    if (ADD_CLOSE_BUTTON && !node.querySelector('.btn-close')) {
                                        const closeButton = document.createElement('button');
                                        closeButton.type = 'button';
                                        closeButton.className = 'btn-close';
                                        closeButton.setAttribute('data-bs-dismiss', 'alert');
                                        closeButton.setAttribute('aria-label', 'Close');
                                        node.appendChild(closeButton);
                                    }
                                    
                                    // Auto-hide
                                    setTimeout(() => {
                                        if (node && node.parentNode) {
                                            try {
                                                if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                                                    const bsAlert = new bootstrap.Alert(node);
                                                    bsAlert.close();
                                                } else {
                                                    node.style.opacity = '0';
                                                    node.style.transition = 'opacity 0.5s ease';
                                                    setTimeout(() => {
                                                        if (node && node.parentNode) {
                                                            node.parentNode.removeChild(node);
                                                        }
                                                    }, 500);
                                                }
                                            } catch (error) {
                                                node.style.opacity = '0';
                                                node.style.transition = 'opacity 0.5s ease';
                                                setTimeout(() => {
                                                    if (node && node.parentNode) {
                                                        node.parentNode.removeChild(node);
                                                    }
                                                }, 500);
                                            }
                                        }
                                    }, AUTO_HIDE_DURATION);
                                }
                            }
                            
                            // Check for alerts within the added node
                            const childAlerts = node.querySelectorAll && node.querySelectorAll('.alert:not(.alert-dismissible)');
                            if (childAlerts) {
                                childAlerts.forEach(alert => {
                                    const shouldAutoHide = ALERT_TYPES.some(type => alert.classList.contains(type));
                                    if (shouldAutoHide) {
                                        alert.classList.add('alert-dismissible');
                                        if (ENABLE_FADE_ANIMATION) {
                                            alert.classList.add('fade', 'show');
                                        }
                                        
                                        if (ADD_CLOSE_BUTTON && !alert.querySelector('.btn-close')) {
                                            const closeButton = document.createElement('button');
                                            closeButton.type = 'button';
                                            closeButton.className = 'btn-close';
                                            closeButton.setAttribute('data-bs-dismiss', 'alert');
                                            closeButton.setAttribute('aria-label', 'Close');
                                            alert.appendChild(closeButton);
                                        }
                                        
                                        setTimeout(() => {
                                            if (alert && alert.parentNode) {
                                                try {
                                                    if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                                                        const bsAlert = new bootstrap.Alert(alert);
                                                        bsAlert.close();
                                                    } else {
                                                        alert.style.opacity = '0';
                                                        alert.style.transition = 'opacity 0.5s ease';
                                                        setTimeout(() => {
                                                            if (alert && alert.parentNode) {
                                                                alert.parentNode.removeChild(alert);
                                                            }
                                                        }, 500);
                                                    }
                                                } catch (error) {
                                                    alert.style.opacity = '0';
                                                    alert.style.transition = 'opacity 0.5s ease';
                                                    setTimeout(() => {
                                                        if (alert && alert.parentNode) {
                                                            alert.parentNode.removeChild(alert);
                                                        }
                                                    }, 500);
                                                }
                                            }
                                        }, AUTO_HIDE_DURATION);
                                    }
                                });
                            }
                        }
                    });
                });
            });
            
            // Start observing
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        }
    }

    var _mobileResolution = {
        onRefresh: function() {
            var windowWidth = window.innerWidth;
            if ( windowWidth <= MediaSize.md ) {
                categoryScroll.scrollCat();
                toggleFunction.sidebar();
            }
        },
        
        onResize: function() {
            window.addEventListener('resize', function(event) {
                event.preventDefault();
                var windowWidth = window.innerWidth;
                if ( windowWidth <= MediaSize.md ) {
                    toggleFunction.offToggleSidebarSubmenu();
                }
            });
        }
        
    }

    var _desktopResolution = {
        onRefresh: function() {
            var windowWidth = window.innerWidth;
            if ( windowWidth > MediaSize.md ) {
                categoryScroll.scrollCat();
                toggleFunction.sidebar();
                toggleFunction.onToggleSidebarSubmenu();
            }
        },
        
        onResize: function() {
            window.addEventListener('resize', function(event) {
                event.preventDefault();
                var windowWidth = window.innerWidth;
                if ( windowWidth > MediaSize.md ) {
                    toggleFunction.onToggleSidebarSubmenu();
                }
            });
        }
        
    }

    function sidebarFunctionality() {
        function sidebarCloser() {

            if (window.innerWidth <= 991 ) {

                if (!document.querySelector('body').classList.contains('alt-menu')) {

                    Dom.id.container.classList.add("sidebar-closed");
                    Dom.class.overlay.classList.remove('show');
                } else {
                    Dom.class.navbar.classList.remove("expand-header");
                    Dom.class.overlay.classList.remove('show');
                    Dom.id.container.classList.remove('sbar-open');
                    Dom.main.classList.remove('sidebar-noneoverflow');
                }

            } else if (window.innerWidth > 991 ) {

                if (!document.querySelector('body').classList.contains('alt-menu')) {

                    Dom.id.container.classList.remove("sidebar-closed");
                    Dom.class.navbar.classList.remove("expand-header");
                    Dom.class.overlay.classList.remove('show');
                    Dom.id.container.classList.remove('sbar-open');
                    Dom.main.classList.remove('sidebar-noneoverflow');
                } else {
                    Dom.main.classList.add('sidebar-noneoverflow');
                    Dom.id.container.classList.add("sidebar-closed");
                    Dom.class.navbar.classList.add("expand-header");
                    Dom.class.overlay.classList.add('show');
                    Dom.id.container.classList.add('sbar-open');
                    document.querySelector('.sidebar-wrapper [aria-expanded="true"]').parentNode.querySelector('.collapse').classList.remove('show');
                }
            }
        }

        function sidebarMobCheck() {
            if (window.innerWidth <= 991 ) {

                if ( document.querySelector('.main-container').classList.contains('sbar-open') ) {
                    return;
                } else {
                    sidebarCloser()
                }
            } else if (window.innerWidth > 991 ) {
                sidebarCloser();
            }
        }

        sidebarCloser();

        window.addEventListener('resize', function(event) {
            sidebarMobCheck();
        });

    }

    return {
        init: function(Layout) {
            toggleFunction.overlay();
            toggleFunction.search();
            toggleFunction.themeToggle(Layout);
            
            /*
                Desktop Resoltion fn
            */
            _desktopResolution.onRefresh();
            _desktopResolution.onResize();

            /*
                Mobile Resoltion fn
            */
            _mobileResolution.onRefresh();
            _mobileResolution.onResize();

            sidebarFunctionality();

            /*
                In Built Functionality fn
            */
            inBuiltfunctionality.mainCatActivateScroll();
            inBuiltfunctionality.notificationScroll();
            inBuiltfunctionality.preventScrollBody();
            inBuiltfunctionality.searchKeyBind();
            inBuiltfunctionality.bsTooltip();
            inBuiltfunctionality.bsPopover();
            inBuiltfunctionality.onCheckandChangeSidebarActiveClass();
            inBuiltfunctionality.MaterialRippleEffect();
            // Delay auto-hide alerts to ensure DOM is fully loaded
            setTimeout(() => {
                inBuiltfunctionality.autoHideAlerts();
            }, 100);
            
            // Also run on DOMContentLoaded to catch any alerts that load later
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    inBuiltfunctionality.autoHideAlerts();
                }, 100);
            });
        }
    }

}();

window.addEventListener('load', function() {
    App.init('layout');
})