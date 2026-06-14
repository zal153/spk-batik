<!doctype html>
<html lang="en">
<!-- [Head] start -->
<!-- Mirrored from dashboardkit.cc/dashboard/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 29 May 2026 10:54:06 GMT -->

<head>
    <title>Home | Dashboardkit Dashboard Template</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Dashboardkit is trending dashboard template made using Bootstrap 5 design framework. Dashboardkit is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies." />
    <meta name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard" />
    <meta name="author" content="Phoenixcoded" />
    <!-- [Favicon] icon -->
    <link rel="icon" href="https://dashboardkit.cc/assets/images/favicon.svg" type="image/x-icon" />
    <!-- [Google Font : Public Sans] icon -->
    <link href="{{ asset('') }}assets/fonts/inter/inter.css" rel="stylesheet" />
    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    <link rel="stylesheet" href="{{ asset('') }}assets/fonts/phosphor/duotone/style.css" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('') }}assets/fonts/tabler-icons.min.css" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('') }}assets/fonts/feather.css" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('') }}assets/fonts/fontawesome.css" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('') }}assets/fonts/material.css" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('') }}assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('') }}assets/css/style-preset.css" />
    <script src="{{ asset('') }}assets/js/tech-stack.js"></script>
    <!-- [simple-datatables] -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/umd/simple-datatables.js"
        type="text/javascript"></script>
    <style>
        .pc-container {
            top: 74px !important;
        }

        .page-header {
            top: 74px !important;
        }

        .pc-container .pc-content {
            padding-top: 20px !important;
        }

        .pc-content .page-header+* {
            margin-top: 75px !important;
        }

        .pc-container .page-header+.row {
            padding-top: 0 !important;
        }

        .pc-container .page-header+.pc-content {
            padding-top: 0 !important;
        }

        /* Datatable styling custom overrides */
        .datatable-wrapper {
            background: #fff;
            border-radius: 12px;
        }

        .datatable-top,
        .datatable-bottom {
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .datatable-top::after,
        .datatable-bottom::after {
            display: none !important;
        }

        .datatable-container {
            border-top: 1px solid #f1f3f5;
            border-bottom: 1px solid #f1f3f5;
        }

        .datatable-input {
            padding: 6px 12px;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 6px;
            outline: none;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .datatable-input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        .datatable-selector {
            padding: 6px 36px 6px 12px;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 6px;
            outline: none;
        }

        .datatable-pagination a {
            padding: 6px 12px;
            margin: 0 2px;
            border-radius: 6px;
            color: #4f46e5;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            text-decoration: none;
        }

        .datatable-pagination .active a,
        .datatable-pagination a:hover {
            background: #4f46e5 !important;
            color: #fff !important;
            border-color: #4f46e5 !important;
        }

        .datatable-pagination .disabled a {
            color: #6c757d;
            pointer-events: none;
            background: #fff;
            border-color: #dee2e6;
        }
    </style>
</head><!-- [Head] end --><!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-theme="dark" data-pc-header-theme="light" data-pc-sidebar-caption="true"
    data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="pc-loader">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End --><!-- [ Sidebar Menu ] start -->
    <x-sidebar />
    <!-- [ Sidebar Menu ] end --><!-- [ Header Topbar ] start -->
    <x-header />
    <!-- [ Header ] end --><!-- [ Main Content ] start -->
    <div class="pc-container">
        {{ $slot }}
    </div>
    <!-- [ Main Content ] end -->
    <x-footer />
    <!-- [ Footer ] end -->
    <!-- [Page Specific JS] start -->
    <script data-cfasync="false" src="{{ asset('') }}cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js">
    </script>
    <script src="{{ asset('') }}assets/js/plugins/apexcharts.min.js"></script>
    <script src="{{ asset('') }}assets/js/widgets/support-chart.js"></script>
    <script src="{{ asset('') }}assets/js/widgets/support-chart1.js"></script>
    <script src="{{ asset('') }}assets/js/widgets/account-chart-1.js"></script>
    <script src="{{ asset('') }}assets/js/widgets/satisfaction-chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new SimpleBar(document.querySelector(".feed-scroll"));
            new SimpleBar(document.querySelector(".pro-scroll"));
        });
    </script>
    <!-- Required Js -->
    <script src="{{ asset('') }}assets/js/plugins/popper.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/simplebar.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/bootstrap.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/i18next.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/i18nextHttpBackend.min.js"></script>
    <script src="{{ asset('') }}assets/js/fonts/custom-font.js"></script>
    <script src="{{ asset('') }}assets/js/pcoded.js"></script>
    <script src="{{ asset('') }}assets/js/theme.js"></script>
    <script src="{{ asset('') }}assets/js/multi-lang.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/feather.min.js"></script>
    <script>
        layout_change("light");
    </script>
    <script>
        layout_sidebar_change("dark");
    </script>
    <script>
        layout_sidebar_change("dark");
    </script>
    <script>
        change_box_container("true");
    </script>
    <script>
        layout_caption_change("true");
    </script>
    <script>
        layout_rtl_change("false");
    </script>
    <script>
        preset_change("preset-1");
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v833ccba57c9e4d2798f2e76cebdd09a11778172276447"
        integrity="sha512-57MDmcccJXYtNnH+ZiBwzC4jb2rvgVCEokYN+L/nLlmO8rfYT/gIpW2A569iJ/3b+0UEasghjuZH/ma3wIs/EQ=="
        data-cf-beacon='{"version":"2024.11.0","token":"5acd44f4abad4a68a2c4415be2ed8669","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}'
        crossorigin="anonymous"></script>
    @vite('resources/js/app.js')
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#4f46e5'
                });
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#4f46e5'
                });
            });
        </script>
    @endif
    @stack('scripts')
</body>
<!-- [Body] end -->
<!-- Mirrored from dashboardkit.cc/dashboard/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 29 May 2026 10:54:17 GMT -->

</html>
