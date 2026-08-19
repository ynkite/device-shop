<!doctype html>
<html lang="kr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>💻 DeviceShop</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link href="{{ asset('my/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('my/css/bootstrap5-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('my/css/all.min.css') }}" rel="stylesheet">

    <!-- ★ CSS를 전부 my.css 로 통합 -->
    <link href="{{ asset('my/css/my.css') }}" rel="stylesheet">

    <script src="{{ asset('my/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('my/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('my/js/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('my/js/bootstrap5-datetimepicker.js') }}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;500;700;800&display=swap" rel="stylesheet">

</head>

<body>

    <!-- 상단 텍스트 슬라이더 -->
    <div class="top-scroll-banner">
        <div class="scroll-text">
            [NEW DESIGN] 혜택 받기 • NEW 5% • 오후 1시 이전 당일배송 • 겨울 리스탁 ❄️ • 앱 다운로드 시 포인트 지급
        </div>
    </div>

    <div class="layout">

        <!-- LEFT SIDEBAR -->
        <div class="left-sidebar">

            <div class="logo">💻 DEVICE SHOP</div>

            <div class="side-menu">
                <a href="{{ route('jangbui.index') }}"><i class="fas fa-hand-holding-usd"></i> 매입</a>
                <a href="{{ route('jangbuo.index') }}"><i class="fas fa-chart-line"></i> 매출</a>
                <a href="{{ route('gigan.index') }}"><i class="fas fa-calendar-alt"></i> 기간조회</a>
                <a href="{{ route('picture.index') }}"><i class="fas fa-images"></i> 사진</a>
                <a href="{{ route('ajax.index') }}"><i class="fas fa-redo-alt"></i> Ajax</a>
                <a href="{{ route('test.index') }}"><i class="fas fa-flask"></i> Test</a>

                <div class="menu-divider"></div>

                <!-- 통계 -->
                <button class="dropdown-btn"><i class="fas fa-chart-pie"></i> 통계 <i class="fas fa-caret-down caret"></i></button>
                <div class="dropdown-content">
                    <a href="{{ route('best.index') }}">BEST 제품</a>
                    <a href="{{ route('crosstab.index') }}">월별 제품별 현황</a>
                    <a href="{{ route('chart.index') }}">종류별 분포도</a>
                </div>

                <!-- 기초정보 -->
                <button class="dropdown-btn"><i class="fas fa-database"></i> 기초정보 <i class="fas fa-caret-down caret"></i></button>
                <div class="dropdown-content">
                    <a href="{{ route('gubun.index') }}">구분</a>
                    <a href="{{ route('product.index') }}">제품</a>

                    @if (session()->get('rank') >= 1)
                        <a href="{{ route('member.index') }}"><i class="fas fa-users-cog"></i> 사용자 관리</a>
                    @endif
                </div>
            </div>

            <!-- LOGIN AREA -->
            <div class="side-bottom-area">
                <div class="side-bottom">

                    @if (!session()->exists('uid'))
                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            LOGIN <i class="fas fa-sign-in-alt"></i>
                        </a>
                    @else
                        <div class="welcome-name">
                            환영합니다, {{ session()->get('name') }}님!
                        </div>
                        <a href="{{ url('login/logout') }}">LOGOUT <i class="fas fa-sign-out-alt"></i></a>
                    @endif

                </div>
            </div>

        </div>

        <!-- MAIN CONTENT -->
        <div class="main">

            <!-- 메인 캐러셀 -->
            <div id="carouselExampleIndicators" class="carousel slide main-slider" data-bs-ride="carousel" data-bs-interval="4000">

                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                </div>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <video autoplay muted loop playsinline>
                            <source src="{{ asset('my/img/4.mp4') }}" type="video/mp4">
                        </video>
                    </div>

                    <div class="carousel-item">
                        <img src="{{ asset('my/img/33.jpg') }}">
                    </div>

                    <div class="carousel-item">
                        <img src="{{ asset('my/img/44.jpg') }}">
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>

            <!-- BEST ITEM -->
            <div class="section-title">
                <i class="fas fa-fire-alt"></i> BEST ITEM
            </div>

            <div class="best-grid">
                <img src="{{ asset('my/img/33.jpg') }}">
                <img src="{{ asset('my/img/44.jpg') }}">
                <img src="{{ asset('my/img/33.jpg') }}">
            </div>

            <!-- 페이지 -->
            <div class="page-content">
                @yield('content')
            </div>

        </div>
    </div>

    <!-- LOGIN MODAL -->
    <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content login-modal">

                <div class="modal-header login-header">
                    <h5 class="modal-title">LOGIN</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body login-body">
                    <form name="form_login" method="post" action="{{ url('login/check') }}">
                        @csrf

                        <label>아이디</label>
                        <input type="text" name="uid" class="form-control form-control-sm">

                        <label style="margin-top:10px;">암호</label>
                        <input type="password" name="pwd" class="form-control form-control-sm">
                    </form>
                </div>

                <div class="modal-footer login-footer">
                    <button type="button" class="btn btn-sm btn-login" onclick="form_login.submit();">확인</button>
                    <button type="button" class="btn btn-sm btn-close2" data-bs-dismiss="modal">닫기</button>
                </div>

            </div>
        </div>
    </div>

    <!-- 드롭다운 제어 -->
    <script>
        document.querySelectorAll('.dropdown-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const content = btn.nextElementSibling;

                document.querySelectorAll('.dropdown-content').forEach(el => {
                    if (el !== content) el.style.display = 'none';
                });

                content.style.display = (content.style.display === 'block') ? 'none' : 'block';

                const icon = btn.querySelector('.caret');
                if (icon) {
                    icon.style.transform = (content.style.display === 'block') ? 'rotate(180deg)' : 'rotate(0deg)';
                }
            });
        });
    </script>

</body>
</html>
