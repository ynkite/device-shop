# DEVICE SHOP

전자기기 판매·재고를 관리하는 백오피스입니다.
매입과 매출을 장부로 기록하고, 기간·제품별 현황을 표와 차트로 집계합니다.

- 기간 2025.04 – 05
- 개인 프로젝트
- 인덕대학교 컴퓨터소프트웨어학과

## 스택

PHP · Laravel · MariaDB · Blade · Bootstrap

## 기능

| 메뉴 | 내용 |
|---|---|
| 매입 | 매입 장부 등록 · 수정 · 조회 |
| 매출 | 매출 장부 등록 · 수정 · 조회 |
| 기간조회 | 기간별 매출입 현황, 엑셀 내려받기 |
| 통계 | BEST 제품, 월별 제품별 현황(크로스탭), 차트 |
| 기초정보 | 제품 · 구분 · 회원 관리 |
| 인증 | 로그인 · 권한 |

## 구조

```
app/Models/           Product · Gubun(구분) · Jangbu(장부) · Member
app/Http/Controllers/ Jangbui(매입) · Jangbuo(매출) · Gigan(기간조회) · Best · Crosstab
                      Chart · Findproduct · Gubun · Member · Login · Ajax · Test
resources/views/      화면 35종 (Blade)
database/migrations/  members · gubuns · products · jangbus · tests
```

## 실행

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

DB 접속 정보는 `.env` 에 둡니다. 저장소에는 올리지 않습니다.
