jQuery(function ($) {
    var hoverBreakpoint = '(min-width: 992px)'; //lg
    var $bsNavDropdown = $('.nav-item.dropdown');
    var $bsNavDropdownLink = $('.nav-link.dropdown-toggle');

    function is_mobile_device() {
        var mobile_user_agent = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        var touch_device = (('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0));
        return mobile_user_agent || touch_device;
    }

    $(window).on('resize setup-bs5-hover-nav', function () {
        if (window.matchMedia(hoverBreakpoint).matches && !is_mobile_device()) {
            $bsNavDropdown.on('mouseenter', function () {
                var $this = $(this);
                $this.find('.nav-link.dropdown-toggle').addClass('show');
                $this.find('.dropdown-menu').addClass('show');
            });

            $bsNavDropdown.on('mouseleave', function () {
                var $this = $(this);
                $this.find('.nav-link.dropdown-toggle').removeClass('show');
                $this.find('.dropdown-menu').removeClass('show');
            });
        }
        else {
            $bsNavDropdown.off('mouseenter mouseleave');
        }

        $bsNavDropdownLink.on('click', function () {
            var $this = $(this);

            if ((is_mobile_device() || !window.matchMedia(hoverBreakpoint).matches) && $this.hasClass('show')) {
                return;
            }

            window.location = $this.attr('href');
        });
    });

    $(window).trigger('setup-bs5-hover-nav');
});
