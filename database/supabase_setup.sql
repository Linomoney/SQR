-- ========================================================
-- SAUNG QURAN RABBANI (SQR) - FULL SUPABASE POSTGRESQL SCRIPT
-- Generated At: 2026-09-04 05:37:12
-- Includes: Complete CREATE TABLE DDL + INSERT DATA DML
-- ========================================================

-- Enable UUID Extension if needed
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- --------------------------------------------------------
-- Table Structure: users
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "users" (
    "id" BIGSERIAL PRIMARY KEY,
    "name" TEXT NOT NULL,
    "email" TEXT NOT NULL,
    "email_verified_at" TIMESTAMP WITHOUT TIME ZONE,
    "password" TEXT NOT NULL,
    "remember_token" TEXT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE,
    "class_id" BIGINT,
    "is_active" BIGINT NOT NULL DEFAULT 1,
    "address" TEXT,
    "photo_url" TEXT,
    "gender" TEXT NOT NULL DEFAULT 'L',
    "nik" TEXT,
    "no_kk" TEXT,
    "phone" TEXT,
    "birth_place" TEXT,
    "birth_date" DATE,
    "education" TEXT,
    "is_profile_completed" BIGINT NOT NULL DEFAULT 0,
    "signature_url" TEXT,
    "location_id" BIGINT
);

-- Data for table: users
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (1, 'Admin Utama SQR', 'admin@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 1, 1, NULL, NULL, 'L', NULL, NULL, 081293721163, NULL, NULL, NULL, 0, NULL, 1) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (2, 'Admin Operasional & Keuangan', 'admin.keuangan@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 1, 1, NULL, NULL, 'P', NULL, NULL, 081299887711, NULL, NULL, NULL, 0, NULL, 1) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (3, 'Ust. Ahmad Fauzi', 'ustadz@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 1, 1, NULL, NULL, 'L', NULL, NULL, 081293721164, NULL, NULL, NULL, 0, NULL, 1) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (4, 'Ustadzah Fatimah Az-Zahra, S.Pd.I', 'ustadzah.fatimah@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 1, 1, NULL, NULL, 'P', NULL, NULL, 081299887766, NULL, NULL, NULL, 0, NULL, 1) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (5, 'Ust. Muhammad Ridwan, Lc', 'ustadz.ridwan@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 2, 1, NULL, NULL, 'L', NULL, NULL, 081388776655, NULL, NULL, NULL, 0, NULL, 2) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (6, 'Ust. Farhan Al-Mansyur, M.Ag', 'ustadz.farhan@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 3, 1, NULL, NULL, 'L', NULL, NULL, 081577665544, NULL, NULL, NULL, 0, NULL, 3) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (7, 'Ustadzah Nurul Hidayah, S.Th.I', 'ustadzah.nurul@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 4, 1, NULL, NULL, 'P', NULL, NULL, 081666554433, NULL, NULL, NULL, 0, NULL, 1) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (8, 'Bpk. Hendra Pratama', 'wali@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', NULL, 1, NULL, NULL, 'L', NULL, NULL, 081293721165, NULL, NULL, NULL, 0, NULL, 1) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (9, 'Bpk. Bambang Setiawan', 'wali.bambang@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', NULL, 1, NULL, NULL, 'L', NULL, NULL, 081311223344, NULL, NULL, NULL, 0, NULL, 1) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (10, 'Ibu Ratna Sari', 'wali.ratna@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', NULL, 1, NULL, NULL, 'P', NULL, NULL, 081422334455, NULL, NULL, NULL, 0, NULL, 1) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (11, 'Bpk. Dr. Agus Wijaya', 'wali.agus@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', NULL, 1, NULL, NULL, 'L', NULL, NULL, 081533445566, NULL, NULL, NULL, 0, NULL, 2) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (12, 'Ibu Dewi Lestari', 'wali.dewi@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', NULL, 1, NULL, NULL, 'P', NULL, NULL, 081644556677, NULL, NULL, NULL, 0, NULL, 2) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (13, 'Bpk. Rahmat Hidayat', 'wali.rahmat@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', NULL, 1, NULL, NULL, 'L', NULL, NULL, 081755667788, NULL, NULL, NULL, 0, NULL, 3) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (14, 'Bpk. Eko Prasetyo', 'wali.eko@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', NULL, 1, NULL, NULL, 'L', NULL, NULL, 081866778899, NULL, NULL, NULL, 0, NULL, 1) ON CONFLICT DO NOTHING;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "class_id", "is_active", "address", "photo_url", "gender", "nik", "no_kk", "phone", "birth_place", "birth_date", "education", "is_profile_completed", "signature_url", "location_id") VALUES (15, 'Ibu Fitriani', 'wali.fitri@sqr.id', NULL, '$2y$12$3iRjbyw5NNOpOMXz0/6LgOrChsUNAsaWpSezkFLINKP/dI9qz6I4O', NULL, '2026-09-04 05:37:05', '2026-09-04 05:37:05', NULL, 1, NULL, NULL, 'P', NULL, NULL, 081977889900, NULL, NULL, NULL, 0, NULL, 1) ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: password_reset_tokens
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "password_reset_tokens" (
    "email" TEXT NOT NULL,
    "token" TEXT NOT NULL,
    "created_at" TIMESTAMP WITHOUT TIME ZONE
);

-- --------------------------------------------------------
-- Table Structure: sessions
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "sessions" (
    "id" TEXT NOT NULL,
    "user_id" BIGINT,
    "ip_address" TEXT,
    "user_agent" TEXT,
    "payload" TEXT NOT NULL,
    "last_activity" BIGINT NOT NULL
);

-- Data for table: sessions
INSERT INTO "sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES ('gbqslBM2ugNPXQD2rFGPNU4wgKwvMTxcVZgkc2iS', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJPOU13ampEWHlIM0todWxYMktmdVFnazh1d2UxT09qQWZNWUNsM0VCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvdXNlcnMiLCJyb3V0ZSI6ImFkbWluLnVzZXJzLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1788496938) ON CONFLICT DO NOTHING;
INSERT INTO "sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES ('xQOxvT9zdDkEoWRajStP4Bc3HYJfZGOYkCfprVE8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; id-ID) WindowsPowerShell/5.1.26100.7462', 'eyJfdG9rZW4iOiJWdzViSmVoNWtnZnV3UXllYmZlbGZrd1dvNWhCTUdVVXFXOW1jVTFuIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1788496793) ON CONFLICT DO NOTHING;
INSERT INTO "sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES ('S4w0dRJkVp4imZgJABR7JWm7EGEailPykMdMGTGG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJXa2Y5aXlpZ096SzQ0MWRYZTZBM2RmeGZhbVVNMnRQUzM3aHNhYWhRIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1788497013) ON CONFLICT DO NOTHING;
INSERT INTO "sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES ('Qytf3tA6X84nT9P1PK1E60kFp0DVS3i9fnBWTG7N', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJDTmhOekFxUkk3cTVQQ21iSlNQR2lTWkxqenpVcG4yYWEybDV6ZW9SIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hcGlcL2FydGlrZWwtbGlzdCIsInJvdXRlIjoiYXBpLmFydGlrZWwifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1788496980) ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: cache
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "cache" (
    "key" TEXT NOT NULL,
    "value" TEXT NOT NULL,
    "expiration" BIGINT NOT NULL
);

-- --------------------------------------------------------
-- Table Structure: cache_locks
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "cache_locks" (
    "key" TEXT NOT NULL,
    "owner" TEXT NOT NULL,
    "expiration" BIGINT NOT NULL
);

-- --------------------------------------------------------
-- Table Structure: jobs
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "jobs" (
    "id" BIGSERIAL PRIMARY KEY,
    "queue" TEXT NOT NULL,
    "payload" TEXT NOT NULL,
    "attempts" BIGINT NOT NULL,
    "reserved_at" BIGINT,
    "available_at" BIGINT NOT NULL,
    "created_at" BIGINT NOT NULL
);

-- --------------------------------------------------------
-- Table Structure: job_batches
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "job_batches" (
    "id" TEXT NOT NULL,
    "name" TEXT NOT NULL,
    "total_jobs" BIGINT NOT NULL,
    "pending_jobs" BIGINT NOT NULL,
    "failed_jobs" BIGINT NOT NULL,
    "failed_job_ids" TEXT NOT NULL,
    "options" TEXT,
    "cancelled_at" BIGINT,
    "created_at" BIGINT NOT NULL,
    "finished_at" BIGINT
);

-- --------------------------------------------------------
-- Table Structure: failed_jobs
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "failed_jobs" (
    "id" BIGSERIAL PRIMARY KEY,
    "uuid" TEXT NOT NULL,
    "connection" TEXT NOT NULL,
    "queue" TEXT NOT NULL,
    "payload" TEXT NOT NULL,
    "exception" TEXT NOT NULL,
    "failed_at" TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------
-- Table Structure: permissions
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "permissions" (
    "id" BIGSERIAL PRIMARY KEY,
    "name" TEXT NOT NULL,
    "guard_name" TEXT NOT NULL,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- --------------------------------------------------------
-- Table Structure: roles
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "roles" (
    "id" BIGSERIAL PRIMARY KEY,
    "name" TEXT NOT NULL,
    "guard_name" TEXT NOT NULL,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: roles
INSERT INTO "roles" ("id", "name", "guard_name", "created_at", "updated_at") VALUES (1, 'admin', 'web', '2026-08-17 23:50:06', '2026-08-17 23:50:06') ON CONFLICT DO NOTHING;
INSERT INTO "roles" ("id", "name", "guard_name", "created_at", "updated_at") VALUES (2, 'ustadz', 'web', '2026-08-17 23:50:06', '2026-08-17 23:50:06') ON CONFLICT DO NOTHING;
INSERT INTO "roles" ("id", "name", "guard_name", "created_at", "updated_at") VALUES (3, 'wali', 'web', '2026-08-17 23:50:06', '2026-08-17 23:50:06') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: model_has_permissions
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "model_has_permissions" (
    "permission_id" BIGINT NOT NULL,
    "model_type" TEXT NOT NULL,
    "model_id" BIGINT NOT NULL,
    PRIMARY KEY ("permission_id", "model_type", "model_id")
);

-- --------------------------------------------------------
-- Table Structure: model_has_roles
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "model_has_roles" (
    "role_id" BIGINT NOT NULL,
    "model_type" TEXT NOT NULL,
    "model_id" BIGINT NOT NULL,
    PRIMARY KEY ("role_id", "model_type", "model_id")
);

-- Data for table: model_has_roles
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (1, 'App\Models\User', 1) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (1, 'App\Models\User', 2) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (2, 'App\Models\User', 3) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (2, 'App\Models\User', 4) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (2, 'App\Models\User', 5) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (2, 'App\Models\User', 6) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (2, 'App\Models\User', 7) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (3, 'App\Models\User', 8) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (3, 'App\Models\User', 9) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (3, 'App\Models\User', 10) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (3, 'App\Models\User', 11) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (3, 'App\Models\User', 12) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (3, 'App\Models\User', 13) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (3, 'App\Models\User', 14) ON CONFLICT DO NOTHING;
INSERT INTO "model_has_roles" ("role_id", "model_type", "model_id") VALUES (3, 'App\Models\User', 15) ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: role_has_permissions
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "role_has_permissions" (
    "permission_id" BIGINT NOT NULL,
    "role_id" BIGINT NOT NULL,
    PRIMARY KEY ("permission_id", "role_id")
);

-- --------------------------------------------------------
-- Table Structure: sqr_locations
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "sqr_locations" (
    "id" BIGSERIAL PRIMARY KEY,
    "name" TEXT NOT NULL,
    "code" TEXT NOT NULL,
    "address" TEXT,
    "latitude" NUMERIC(15,2) NOT NULL DEFAULT -6.397637,
    "longitude" NUMERIC(15,2) NOT NULL DEFAULT 106.877478,
    "radius_meters" BIGINT NOT NULL DEFAULT 150,
    "is_active" BIGINT NOT NULL DEFAULT 1,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: sqr_locations
INSERT INTO "sqr_locations" ("id", "name", "code", "address", "latitude", "longitude", "radius_meters", "is_active", "created_at", "updated_at") VALUES (1, 'SQR Utama (Sukatani, Tapos Depok)', 'SQR-UTAMA', 'Jl. Puri Kemang Permai No.85, RT.002/008, Sukatani, Tapos Depok', '-6.393733', 106.878266, 30, 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "sqr_locations" ("id", "name", "code", "address", "latitude", "longitude", "radius_meters", "is_active", "created_at", "updated_at") VALUES (2, 'SQR Cabang Tapos', 'SQR-TAPOS', 'Jl. Raya Tapos No. 12, Tapos Depok', '-6.402', 106.882, 100, 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "sqr_locations" ("id", "name", "code", "address", "latitude", "longitude", "radius_meters", "is_active", "created_at", "updated_at") VALUES (3, 'SQR Cabang Cimanggis', 'SQR-CIMANGGIS', 'Jl. Raya Bogor KM 30, Cimanggis Depok', '-6.365', 106.865, 100, 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "sqr_locations" ("id", "name", "code", "address", "latitude", "longitude", "radius_meters", "is_active", "created_at", "updated_at") VALUES (4, 'SQR Cabang Sawangan', 'SQR-SAWANGAN', 'Jl. Raya Sawangan No. 45, Sawangan Depok', '-6.391', 106.782, 150, 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "sqr_locations" ("id", "name", "code", "address", "latitude", "longitude", "radius_meters", "is_active", "created_at", "updated_at") VALUES (5, 'SQR Cabang Beji', 'SQR-BEJI', 'Jl. Nusantara Raya No. 88, Beji Depok', '-6.372', 106.821, 120, 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: classes
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "classes" (
    "id" BIGSERIAL PRIMARY KEY,
    "class_name" TEXT NOT NULL,
    "description" TEXT,
    "quota" BIGINT NOT NULL DEFAULT 30,
    "is_active" BIGINT NOT NULL DEFAULT 1,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE,
    "start_time" TEXT NOT NULL DEFAULT '15:30',
    "end_time" TEXT NOT NULL DEFAULT '17:00',
    "attendance_start_time" TEXT NOT NULL DEFAULT '15:30',
    "attendance_end_time" TEXT NOT NULL DEFAULT '16:15',
    "certificate_target" BIGINT NOT NULL DEFAULT 100,
    "recommendation_target" BIGINT NOT NULL DEFAULT 50,
    "location_id" BIGINT
);

-- Data for table: classes
INSERT INTO "classes" ("id", "class_name", "description", "quota", "is_active", "created_at", "updated_at", "start_time", "end_time", "attendance_start_time", "attendance_end_time", "certificate_target", "recommendation_target", "location_id") VALUES (1, 'Kelas Anak A (Ummi 1 - 3)', 'Kelas tahsin anak usia 5-8 thn', 25, 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '15:30', '17:00', '15:30', '16:15', 100, 50, 1) ON CONFLICT DO NOTHING;
INSERT INTO "classes" ("id", "class_name", "description", "quota", "is_active", "created_at", "updated_at", "start_time", "end_time", "attendance_start_time", "attendance_end_time", "certificate_target", "recommendation_target", "location_id") VALUES (2, 'Kelas Anak B (Ummi 4 - 6)', 'Kelas lanjutan anak usia 9-12 thn', 25, 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '15:30', '17:00', '15:30', '16:15', 100, 50, 1) ON CONFLICT DO NOTHING;
INSERT INTO "classes" ("id", "class_name", "description", "quota", "is_active", "created_at", "updated_at", "start_time", "end_time", "attendance_start_time", "attendance_end_time", "certificate_target", "recommendation_target", "location_id") VALUES (3, 'Kelas Remaja A (Tahfidz Juz 30)', 'Kelas tahfidz Juz 30 remaja 13-15 thn', 30, 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '15:30', '17:00', '15:30', '16:15', 100, 50, 1) ON CONFLICT DO NOTHING;
INSERT INTO "classes" ("id", "class_name", "description", "quota", "is_active", "created_at", "updated_at", "start_time", "end_time", "attendance_start_time", "attendance_end_time", "certificate_target", "recommendation_target", "location_id") VALUES (4, 'Kelas Remaja B (Tahfidz Juz 29 & 30)', 'Kelas tahfidz mutqin 2 juz remaja', 30, 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '15:30', '17:00', '15:30', '16:15', 100, 50, 2) ON CONFLICT DO NOTHING;
INSERT INTO "classes" ("id", "class_name", "description", "quota", "is_active", "created_at", "updated_at", "start_time", "end_time", "attendance_start_time", "attendance_end_time", "certificate_target", "recommendation_target", "location_id") VALUES (5, 'Kelas Dewasa (Tahsin & Tajwid)', 'Kelas tahsin & tajwid Al-Quran dewasa 18+ thn', 30, 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '19:30', '21:00', '19:30', '20:15', 100, 50, 1) ON CONFLICT DO NOTHING;
INSERT INTO "classes" ("id", "class_name", "description", "quota", "is_active", "created_at", "updated_at", "start_time", "end_time", "attendance_start_time", "attendance_end_time", "certificate_target", "recommendation_target", "location_id") VALUES (6, 'Kelas Intensif Matan Al-Jazariyyah', 'Kelas pendalaman sanad tajwid & ghorib', 20, 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '19:30', '21:00', '19:30', '20:15', 100, 50, 3) ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: santri
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "santri" (
    "id" BIGSERIAL PRIMARY KEY,
    "full_name" TEXT NOT NULL,
    "date_of_birth" DATE,
    "gender" TEXT NOT NULL,
    "parent_name" TEXT,
    "phone" TEXT,
    "wali_user_id" BIGINT,
    "class_id" BIGINT,
    "enrollment_date" DATE,
    "is_active" BIGINT NOT NULL DEFAULT 1,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE,
    "certificate_template" TEXT NOT NULL DEFAULT 'classic',
    "certificate_issued_at" TIMESTAMP WITHOUT TIME ZONE,
    "birth_place" TEXT,
    "address" TEXT
);

-- Data for table: santri
INSERT INTO "santri" ("id", "full_name", "date_of_birth", "gender", "parent_name", "phone", "wali_user_id", "class_id", "enrollment_date", "is_active", "created_at", "updated_at", "certificate_template", "certificate_issued_at", "birth_place", "address") VALUES (1, 'Muhammad Rizki Pratama', '2016-04-12', 'Laki-laki', 'Bpk. Hendra Pratama', 081293721165, 8, 1, '2025-01-10', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 'elegant', NULL, 'Depok', 'Jl. Puri Kemang Permai No. 85') ON CONFLICT DO NOTHING;
INSERT INTO "santri" ("id", "full_name", "date_of_birth", "gender", "parent_name", "phone", "wali_user_id", "class_id", "enrollment_date", "is_active", "created_at", "updated_at", "certificate_template", "certificate_issued_at", "birth_place", "address") VALUES (2, 'Aisyah Az-Zahra', '2014-08-22', 'Perempuan', 'Bpk. Hendra Pratama', 081293721165, 8, 3, '2025-02-01', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 'classic', NULL, 'Depok', 'Jl. Puri Kemang Permai No. 85') ON CONFLICT DO NOTHING;
INSERT INTO "santri" ("id", "full_name", "date_of_birth", "gender", "parent_name", "phone", "wali_user_id", "class_id", "enrollment_date", "is_active", "created_at", "updated_at", "certificate_template", "certificate_issued_at", "birth_place", "address") VALUES (3, 'Fadhil Ahmad Setiawan', '2017-03-15', 'Laki-laki', 'Bpk. Bambang Setiawan', 081311223344, 9, 1, '2025-01-15', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 'premium', NULL, 'Jakarta', 'Jl. Margonda Raya No. 45') ON CONFLICT DO NOTHING;
INSERT INTO "santri" ("id", "full_name", "date_of_birth", "gender", "parent_name", "phone", "wali_user_id", "class_id", "enrollment_date", "is_active", "created_at", "updated_at", "certificate_template", "certificate_issued_at", "birth_place", "address") VALUES (4, 'Zahra Nur Syafira', '2015-11-05', 'Perempuan', 'Ibu Ratna Sari', 081422334455, 10, 2, '2025-03-01', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 'elegant', NULL, 'Depok', 'Jl. Raya Tapos No. 10') ON CONFLICT DO NOTHING;
INSERT INTO "santri" ("id", "full_name", "date_of_birth", "gender", "parent_name", "phone", "wali_user_id", "class_id", "enrollment_date", "is_active", "created_at", "updated_at", "certificate_template", "certificate_issued_at", "birth_place", "address") VALUES (5, 'Rayhan Malik Wijaya', '2013-09-18', 'Laki-laki', 'Bpk. Dr. Agus Wijaya', 081533445566, 11, 4, '2025-01-05', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 'premium', NULL, 'Bogor', 'Jl. Pajajaran No. 88') ON CONFLICT DO NOTHING;
INSERT INTO "santri" ("id", "full_name", "date_of_birth", "gender", "parent_name", "phone", "wali_user_id", "class_id", "enrollment_date", "is_active", "created_at", "updated_at", "certificate_template", "certificate_issued_at", "birth_place", "address") VALUES (6, 'Khadijah Nabila', '2018-01-30', 'Perempuan', 'Ibu Dewi Lestari', 081644556677, 12, 1, '2025-04-10', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 'classic', NULL, 'Depok', 'Jl. Akses UI No. 12') ON CONFLICT DO NOTHING;
INSERT INTO "santri" ("id", "full_name", "date_of_birth", "gender", "parent_name", "phone", "wali_user_id", "class_id", "enrollment_date", "is_active", "created_at", "updated_at", "certificate_template", "certificate_issued_at", "birth_place", "address") VALUES (7, 'Umar Abdul Aziz', '2012-06-14', 'Laki-laki', 'Bpk. Rahmat Hidayat', 081755667788, 13, 4, '2025-01-20', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 'elegant', NULL, 'Depok', 'Jl. Raya Cimanggis No. 99') ON CONFLICT DO NOTHING;
INSERT INTO "santri" ("id", "full_name", "date_of_birth", "gender", "parent_name", "phone", "wali_user_id", "class_id", "enrollment_date", "is_active", "created_at", "updated_at", "certificate_template", "certificate_issued_at", "birth_place", "address") VALUES (8, 'Bilal Ibn Rabah Prasetyo', '2016-12-25', 'Laki-laki', 'Bpk. Eko Prasetyo', 081866778899, 14, 2, '2025-02-15', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 'classic', NULL, 'Depok', 'Jl. Kartini No. 34') ON CONFLICT DO NOTHING;
INSERT INTO "santri" ("id", "full_name", "date_of_birth", "gender", "parent_name", "phone", "wali_user_id", "class_id", "enrollment_date", "is_active", "created_at", "updated_at", "certificate_template", "certificate_issued_at", "birth_place", "address") VALUES (9, 'Maryam Al-Thafunnisa', '2017-07-07', 'Perempuan', 'Ibu Fitriani', 081977889900, 15, 1, '2025-03-10', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 'premium', NULL, 'Depok', 'Jl. Juanda No. 56') ON CONFLICT DO NOTHING;
INSERT INTO "santri" ("id", "full_name", "date_of_birth", "gender", "parent_name", "phone", "wali_user_id", "class_id", "enrollment_date", "is_active", "created_at", "updated_at", "certificate_template", "certificate_issued_at", "birth_place", "address") VALUES (10, 'Hamzah Asadullah', '2015-05-19', 'Laki-laki', 'Bpk. Hendra Pratama', 081293721165, 8, 3, '2025-05-01', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', 'elegant', NULL, 'Depok', 'Jl. Puri Kemang Permai No. 85') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: ppdb
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "ppdb" (
    "id" BIGSERIAL PRIMARY KEY,
    "nama_ayah" TEXT,
    "nama_ibu" TEXT,
    "pekerjaan_ayah" TEXT,
    "pekerjaan_ibu" TEXT,
    "no_hp_ayah" TEXT,
    "no_hp_ibu" TEXT,
    "penghasilan_bulanan" TEXT,
    "nama_lengkap" TEXT NOT NULL,
    "tempat_lahir" TEXT,
    "tanggal_lahir" DATE,
    "anak_ke" BIGINT,
    "jumlah_saudara" BIGINT,
    "sekolah_asal" TEXT,
    "gender" TEXT NOT NULL,
    "email" TEXT,
    "no_telephone" TEXT,
    "alamat" TEXT,
    "rt" TEXT,
    "rw" TEXT,
    "desa_kelurahan" TEXT,
    "kota" TEXT,
    "kelas_diminati" BIGINT,
    "status" TEXT NOT NULL DEFAULT 'Pending',
    "catatan_admin" TEXT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- --------------------------------------------------------
-- Table Structure: student_progress
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "student_progress" (
    "id" BIGSERIAL PRIMARY KEY,
    "santri_id" BIGINT NOT NULL,
    "date" DATE NOT NULL,
    "juz_start" BIGINT,
    "juz_end" BIGINT,
    "surah_memorized" TEXT,
    "notes" TEXT,
    "ustadz_user_id" BIGINT,
    "type" TEXT NOT NULL DEFAULT 'Tahfiz',
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: student_progress
INSERT INTO "student_progress" ("id", "santri_id", "date", "juz_start", "juz_end", "surah_memorized", "notes", "ustadz_user_id", "type", "created_at", "updated_at") VALUES (1, 1, '2026-08-01', 1, 30, 'An-Nas', '⭐ Predikat: Mumtaz (Sangat Lancar) | Lulus mutqin 30 Juz', 3, 'Tahfiz', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "student_progress" ("id", "santri_id", "date", "juz_start", "juz_end", "surah_memorized", "notes", "ustadz_user_id", "type", "created_at", "updated_at") VALUES (2, 2, '2026-08-02', 30, 30, 'An-Naba', 'Lancar juz 30, tajwid makhraj bagus', 4, 'Tahfiz', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "student_progress" ("id", "santri_id", "date", "juz_start", "juz_end", "surah_memorized", "notes", "ustadz_user_id", "type", "created_at", "updated_at") VALUES (3, 3, '2026-08-03', 1, 1, 'Al-Fatiha', 'Kelulusan Ummi Jilid 2', 3, 'Tahsin', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "student_progress" ("id", "santri_id", "date", "juz_start", "juz_end", "surah_memorized", "notes", "ustadz_user_id", "type", "created_at", "updated_at") VALUES (4, 4, '2026-08-04', 30, 30, 'Al-Mulk', 'Setoran surat Al-Mulk 1-15 lancar', 4, 'Tahfiz', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "student_progress" ("id", "santri_id", "date", "juz_start", "juz_end", "surah_memorized", "notes", "ustadz_user_id", "type", "created_at", "updated_at") VALUES (5, 5, '2026-08-05', 29, 30, 'Al-Haqqah', 'Hafalan Juz 29 & 30 mutqin', 5, 'Tahfiz', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: payments
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "payments" (
    "id" BIGSERIAL PRIMARY KEY,
    "santri_id" BIGINT NOT NULL,
    "month_year" TEXT NOT NULL,
    "amount" BIGINT NOT NULL DEFAULT 0,
    "status" TEXT NOT NULL DEFAULT 'Unpaid',
    "notes" TEXT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: payments
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (1, 1, '2025-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-01', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (2, 1, '2025-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-02', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (3, 1, '2025-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-03', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (4, 1, '2025-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-04', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (5, 1, '2025-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (6, 1, '2025-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-06', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (7, 1, '2025-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-07', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (8, 1, '2025-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-08', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (9, 1, '2025-09', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-09', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (10, 1, '2025-10', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-10', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (11, 1, '2025-11', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-11', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (12, 1, '2025-12', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-12', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (13, 1, '2026-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-01', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (14, 1, '2026-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-02', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (15, 1, '2026-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-03', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (16, 1, '2026-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-04', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (17, 1, '2026-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (18, 1, '2026-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-06', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (19, 1, '2026-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-07', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (20, 1, '2026-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-08', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (21, 1, '2026-09', 150000, 'Pending', 'Pembayaran SPP Syahriyah 2026-09', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (22, 1, '2026-10', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-10', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (23, 1, '2026-11', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-11', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (24, 1, '2026-12', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-12', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (25, 2, '2025-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-01', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (26, 2, '2025-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-02', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (27, 2, '2025-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-03', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (28, 2, '2025-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-04', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (29, 2, '2025-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-05', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (30, 2, '2025-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (31, 2, '2025-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-07', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (32, 2, '2025-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-08', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (33, 2, '2025-09', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-09', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (34, 2, '2025-10', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-10', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (35, 2, '2025-11', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-11', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (36, 2, '2025-12', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-12', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (37, 2, '2026-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-01', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (38, 2, '2026-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-02', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (39, 2, '2026-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-03', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (40, 2, '2026-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-04', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (41, 2, '2026-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-05', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (42, 2, '2026-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (43, 2, '2026-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-07', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (44, 2, '2026-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-08', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (45, 2, '2026-09', 150000, 'Pending', 'Pembayaran SPP Syahriyah 2026-09', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (46, 2, '2026-10', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-10', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (47, 2, '2026-11', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-11', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (48, 2, '2026-12', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-12', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (49, 3, '2025-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-01', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (50, 3, '2025-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-02', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (51, 3, '2025-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-03', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (52, 3, '2025-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-04', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (53, 3, '2025-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-05', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (54, 3, '2025-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (55, 3, '2025-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-07', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (56, 3, '2025-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-08', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (57, 3, '2025-09', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-09', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (58, 3, '2025-10', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-10', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (59, 3, '2025-11', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-11', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (60, 3, '2025-12', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-12', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (61, 3, '2026-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-01', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (62, 3, '2026-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-02', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (63, 3, '2026-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-03', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (64, 3, '2026-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-04', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (65, 3, '2026-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-05', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (66, 3, '2026-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (67, 3, '2026-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-07', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (68, 3, '2026-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-08', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (69, 3, '2026-09', 150000, 'Pending', 'Pembayaran SPP Syahriyah 2026-09', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (70, 3, '2026-10', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-10', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (71, 3, '2026-11', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-11', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (72, 3, '2026-12', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-12', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (73, 4, '2025-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-01', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (74, 4, '2025-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-02', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (75, 4, '2025-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-03', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (76, 4, '2025-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-04', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (77, 4, '2025-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-05', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (78, 4, '2025-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (79, 4, '2025-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-07', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (80, 4, '2025-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-08', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (81, 4, '2025-09', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-09', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (82, 4, '2025-10', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-10', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (83, 4, '2025-11', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-11', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (84, 4, '2025-12', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-12', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (85, 4, '2026-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-01', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (86, 4, '2026-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-02', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (87, 4, '2026-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-03', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (88, 4, '2026-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-04', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (89, 4, '2026-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-05', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (90, 4, '2026-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-06', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (91, 4, '2026-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (92, 4, '2026-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-08', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (93, 4, '2026-09', 150000, 'Pending', 'Pembayaran SPP Syahriyah 2026-09', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (94, 4, '2026-10', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-10', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (95, 4, '2026-11', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-11', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (96, 4, '2026-12', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-12', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (97, 5, '2025-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-01', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (98, 5, '2025-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-02', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (99, 5, '2025-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-03', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (100, 5, '2025-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-04', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (101, 5, '2025-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-05', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (102, 5, '2025-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-06', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (103, 5, '2025-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (104, 5, '2025-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-08', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (105, 5, '2025-09', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-09', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (106, 5, '2025-10', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-10', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (107, 5, '2025-11', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-11', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (108, 5, '2025-12', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-12', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (109, 5, '2026-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-01', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (110, 5, '2026-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-02', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (111, 5, '2026-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-03', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (112, 5, '2026-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-04', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (113, 5, '2026-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-05', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (114, 5, '2026-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-06', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (115, 5, '2026-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (116, 5, '2026-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-08', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (117, 5, '2026-09', 150000, 'Pending', 'Pembayaran SPP Syahriyah 2026-09', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (118, 5, '2026-10', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-10', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (119, 5, '2026-11', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-11', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (120, 5, '2026-12', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-12', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (121, 6, '2025-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-01', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (122, 6, '2025-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-02', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (123, 6, '2025-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-03', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (124, 6, '2025-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-04', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (125, 6, '2025-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-05', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (126, 6, '2025-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-06', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (127, 6, '2025-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (128, 6, '2025-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-08', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (129, 6, '2025-09', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-09', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (130, 6, '2025-10', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-10', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (131, 6, '2025-11', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-11', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (132, 6, '2025-12', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-12', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (133, 6, '2026-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-01', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (134, 6, '2026-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-02', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (135, 6, '2026-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-03', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (136, 6, '2026-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-04', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (137, 6, '2026-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-05', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (138, 6, '2026-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-06', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (139, 6, '2026-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (140, 6, '2026-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-08', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (141, 6, '2026-09', 150000, 'Pending', 'Pembayaran SPP Syahriyah 2026-09', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (142, 6, '2026-10', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-10', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (143, 6, '2026-11', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-11', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (144, 6, '2026-12', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-12', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (145, 7, '2025-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-01', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (146, 7, '2025-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-02', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (147, 7, '2025-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-03', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (148, 7, '2025-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-04', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (149, 7, '2025-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-05', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (150, 7, '2025-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-06', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (151, 7, '2025-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-07', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (152, 7, '2025-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (153, 7, '2025-09', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-09', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (154, 7, '2025-10', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-10', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (155, 7, '2025-11', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-11', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (156, 7, '2025-12', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-12', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (157, 7, '2026-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-01', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (158, 7, '2026-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-02', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (159, 7, '2026-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-03', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (160, 7, '2026-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-04', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (161, 7, '2026-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-05', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (162, 7, '2026-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-06', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (163, 7, '2026-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-07', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (164, 7, '2026-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (165, 7, '2026-09', 150000, 'Pending', 'Pembayaran SPP Syahriyah 2026-09', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (166, 7, '2026-10', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-10', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (167, 7, '2026-11', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-11', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (168, 7, '2026-12', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-12', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (169, 8, '2025-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-01', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (170, 8, '2025-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-02', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (171, 8, '2025-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-03', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (172, 8, '2025-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-04', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (173, 8, '2025-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-05', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (174, 8, '2025-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-06', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (175, 8, '2025-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-07', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (176, 8, '2025-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (177, 8, '2025-09', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-09', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (178, 8, '2025-10', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-10', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (179, 8, '2025-11', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-11', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (180, 8, '2025-12', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-12', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (181, 8, '2026-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-01', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (182, 8, '2026-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-02', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (183, 8, '2026-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-03', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (184, 8, '2026-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-04', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (185, 8, '2026-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-05', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (186, 8, '2026-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-06', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (187, 8, '2026-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-07', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (188, 8, '2026-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (189, 8, '2026-09', 150000, 'Pending', 'Pembayaran SPP Syahriyah 2026-09', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (190, 8, '2026-10', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-10', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (191, 8, '2026-11', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-11', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (192, 8, '2026-12', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-12', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (193, 9, '2025-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-01', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (194, 9, '2025-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-02', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (195, 9, '2025-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-03', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (196, 9, '2025-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-04', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (197, 9, '2025-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-05', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (198, 9, '2025-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-06', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (199, 9, '2025-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-07', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (200, 9, '2025-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (201, 9, '2025-09', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-09', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (202, 9, '2025-10', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-10', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (203, 9, '2025-11', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-11', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (204, 9, '2025-12', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-12', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (205, 9, '2026-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-01', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (206, 9, '2026-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-02', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (207, 9, '2026-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-03', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (208, 9, '2026-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-04', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (209, 9, '2026-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-05', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (210, 9, '2026-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-06', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (211, 9, '2026-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-07', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (212, 9, '2026-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-08', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (213, 9, '2026-09', 150000, 'Pending', 'Pembayaran SPP Syahriyah 2026-09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (214, 9, '2026-10', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-10', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (215, 9, '2026-11', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-11', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (216, 9, '2026-12', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-12', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (217, 10, '2025-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-01', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (218, 10, '2025-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-02', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (219, 10, '2025-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-03', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (220, 10, '2025-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-04', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (221, 10, '2025-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-05', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (222, 10, '2025-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-06', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (223, 10, '2025-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-07', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (224, 10, '2025-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-08', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (225, 10, '2025-09', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (226, 10, '2025-10', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-10', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (227, 10, '2025-11', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-11', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (228, 10, '2025-12', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2025-12', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (229, 10, '2026-01', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-01', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (230, 10, '2026-02', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-02', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (231, 10, '2026-03', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-03', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (232, 10, '2026-04', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-04', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (233, 10, '2026-05', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-05', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (234, 10, '2026-06', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-06', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (235, 10, '2026-07', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-07', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (236, 10, '2026-08', 150000, 'Verified', 'Pembayaran SPP Syahriyah 2026-08', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (237, 10, '2026-09', 150000, 'Pending', 'Pembayaran SPP Syahriyah 2026-09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (238, 10, '2026-10', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-10', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (239, 10, '2026-11', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-11', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payments" ("id", "santri_id", "month_year", "amount", "status", "notes", "created_at", "updated_at") VALUES (240, 10, '2026-12', 150000, 'Unpaid', 'Pembayaran SPP Syahriyah 2026-12', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: payment_verifications
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "payment_verifications" (
    "id" BIGSERIAL PRIMARY KEY,
    "payment_id" BIGINT NOT NULL,
    "wali_user_id" BIGINT,
    "proof_image_path" TEXT,
    "status" TEXT NOT NULL DEFAULT 'Pending',
    "admin_notes" TEXT,
    "verified_by" BIGINT,
    "verified_at" TIMESTAMP WITHOUT TIME ZONE,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: payment_verifications
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (1, 1, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (2, 2, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (3, 3, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (4, 4, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (5, 5, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (6, 6, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (7, 7, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (8, 8, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (9, 9, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (10, 10, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (11, 11, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (12, 12, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (13, 13, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (14, 14, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (15, 15, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (16, 16, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (17, 17, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (18, 18, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (19, 19, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (20, 20, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:05', '2026-09-04 05:37:05', '2026-09-04 05:37:05') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (21, 21, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Pending', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (22, 25, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (23, 26, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (24, 27, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (25, 28, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (26, 29, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (27, 30, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (28, 31, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (29, 32, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (30, 33, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (31, 34, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (32, 35, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (33, 36, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (34, 37, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (35, 38, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (36, 39, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (37, 40, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (38, 41, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (39, 42, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (40, 43, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (41, 44, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (42, 45, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Pending', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (43, 49, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (44, 50, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (45, 51, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (46, 52, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (47, 53, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (48, 54, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (49, 55, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (50, 56, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (51, 57, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (52, 58, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (53, 59, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (54, 60, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (55, 61, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (56, 62, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (57, 63, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (58, 64, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (59, 65, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (60, 66, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (61, 67, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (62, 68, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (63, 69, 9, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Pending', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (64, 73, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (65, 74, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (66, 75, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (67, 76, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (68, 77, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (69, 78, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (70, 79, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (71, 80, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (72, 81, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:06', '2026-09-04 05:37:06', '2026-09-04 05:37:06') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (73, 82, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (74, 83, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (75, 84, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (76, 85, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (77, 86, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (78, 87, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (79, 88, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (80, 89, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (81, 90, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (82, 91, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (83, 92, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (84, 93, 10, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Pending', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (85, 97, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (86, 98, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (87, 99, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (88, 100, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (89, 101, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (90, 102, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (91, 103, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (92, 104, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (93, 105, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (94, 106, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (95, 107, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (96, 108, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (97, 109, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (98, 110, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (99, 111, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (100, 112, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (101, 113, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (102, 114, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (103, 115, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (104, 116, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (105, 117, 11, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Pending', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (106, 121, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (107, 122, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (108, 123, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (109, 124, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (110, 125, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (111, 126, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (112, 127, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (113, 128, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (114, 129, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (115, 130, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (116, 131, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (117, 132, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (118, 133, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (119, 134, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (120, 135, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (121, 136, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (122, 137, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (123, 138, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (124, 139, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (125, 140, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (126, 141, 12, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Pending', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (127, 145, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:07', '2026-09-04 05:37:07', '2026-09-04 05:37:07') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (128, 146, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (129, 147, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (130, 148, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (131, 149, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (132, 150, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (133, 151, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (134, 152, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (135, 153, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (136, 154, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (137, 155, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (138, 156, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (139, 157, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (140, 158, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (141, 159, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (142, 160, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (143, 161, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (144, 162, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (145, 163, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (146, 164, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (147, 165, 13, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Pending', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (148, 169, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (149, 170, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (150, 171, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (151, 172, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (152, 173, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (153, 174, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (154, 175, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (155, 176, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (156, 177, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (157, 178, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (158, 179, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (159, 180, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (160, 181, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (161, 182, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (162, 183, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (163, 184, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (164, 185, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (165, 186, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (166, 187, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (167, 188, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (168, 189, 14, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Pending', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (169, 193, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (170, 194, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (171, 195, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (172, 196, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (173, 197, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (174, 198, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (175, 199, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (176, 200, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (177, 201, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (178, 202, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (179, 203, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:08', '2026-09-04 05:37:08', '2026-09-04 05:37:08') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (180, 204, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (181, 205, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (182, 206, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (183, 207, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (184, 208, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (185, 209, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (186, 210, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (187, 211, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (188, 212, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (189, 213, 15, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Pending', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (190, 217, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (191, 218, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (192, 219, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (193, 220, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (194, 221, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (195, 222, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (196, 223, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (197, 224, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (198, 225, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (199, 226, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (200, 227, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (201, 228, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (202, 229, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (203, 230, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (204, 231, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (205, 232, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (206, 233, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (207, 234, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (208, 235, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (209, 236, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Verified', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "payment_verifications" ("id", "payment_id", "wali_user_id", "proof_image_path", "status", "admin_notes", "verified_by", "verified_at", "created_at", "updated_at") VALUES (210, 237, 8, 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', 'Pending', 'Pembayaran SPP Syahriyah terverifikasi sistem', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: income
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "income" (
    "id" BIGSERIAL PRIMARY KEY,
    "title" TEXT NOT NULL,
    "description" TEXT,
    "amount" BIGINT NOT NULL,
    "date" DATE NOT NULL,
    "category" TEXT,
    "recorded_by" BIGINT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: income
INSERT INTO "income" ("id", "title", "description", "amount", "date", "category", "recorded_by", "created_at", "updated_at") VALUES (1, 'Infaq Kotak Jumat Berkah SQR Utama', 'Hasil perolehan infaq jamaah Jumat', 1250000, '2026-08-01', 'Infaq', NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "income" ("id", "title", "description", "amount", "date", "category", "recorded_by", "created_at", "updated_at") VALUES (2, 'Ta''awun Donatur Tetap Operasional', 'Transfer bantuan ta''awun Hamba Allah', 2500000, '2026-08-05', 'Donasi', NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "income" ("id", "title", "description", "amount", "date", "category", "recorded_by", "created_at", "updated_at") VALUES (3, 'Pendaftaran PPDB Gelombang 1', 'Biaya pendaftaran 5 calon santri baru', 1500000, '2026-08-10', 'PPDB', NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "income" ("id", "title", "description", "amount", "date", "category", "recorded_by", "created_at", "updated_at") VALUES (4, 'Infaq Orang Tua Wisuda Tahfidz', 'Sumbangan sukarela acara haflah sanah', 3200000, '2026-08-15', 'Kegiatan', NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: expenses
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "expenses" (
    "id" BIGSERIAL PRIMARY KEY,
    "title" TEXT NOT NULL,
    "description" TEXT,
    "amount" BIGINT NOT NULL,
    "date" DATE NOT NULL,
    "category" TEXT,
    "recorded_by" BIGINT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: expenses
INSERT INTO "expenses" ("id", "title", "description", "amount", "date", "category", "recorded_by", "created_at", "updated_at") VALUES (1, 'Konsumsi & Snack Kajian Wali Santri', 'Kue kotak & minuman peserta kajian bulanan', 450000, '2026-08-02', 'Konsumsi & Acara', NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "expenses" ("id", "title", "description", "amount", "date", "category", "recorded_by", "created_at", "updated_at") VALUES (2, 'Program Jumat Berbagi - 100 Paket Nasi', 'Pembagian nasi berkah warga & santri', 1000000, '2026-08-08', 'Program Sosial & Sumbangan', NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "expenses" ("id", "title", "description", "amount", "date", "category", "recorded_by", "created_at", "updated_at") VALUES (3, 'Hadiah Piala & Sertifikat Wisudawan', 'Pengadaan trofi mutqin & percetakan sertifikat', 850000, '2026-08-12', 'Kegiatan Santri', NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "expenses" ("id", "title", "description", "amount", "date", "category", "recorded_by", "created_at", "updated_at") VALUES (4, 'Pembelian 20 Mus-haf Al-Quran Tajwid', 'Pengadaan Al-Quran hafalan Tajwid warna', 1400000, '2026-08-16', 'Sarana Belajar', NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: content_manager
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "content_manager" (
    "id" BIGSERIAL PRIMARY KEY,
    "key" TEXT NOT NULL,
    "value" TEXT,
    "type" TEXT NOT NULL DEFAULT 'text',
    "updated_by" BIGINT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: content_manager
INSERT INTO "content_manager" ("id", "key", "value", "type", "updated_by", "created_at", "updated_at") VALUES (1, 'home_tagline', 'Pondasi Quran Generasi Rabbani', 'text', NULL, '2026-08-17 23:50:18', '2026-08-17 23:50:18') ON CONFLICT DO NOTHING;
INSERT INTO "content_manager" ("id", "key", "value", "type", "updated_by", "created_at", "updated_at") VALUES (2, 'stat_total_santri', '150+', 'text', NULL, '2026-08-17 23:50:18', '2026-08-17 23:50:18') ON CONFLICT DO NOTHING;
INSERT INTO "content_manager" ("id", "key", "value", "type", "updated_by", "created_at", "updated_at") VALUES (3, 'stat_pengajar', '8+', 'text', NULL, '2026-08-17 23:50:18', '2026-08-17 23:50:18') ON CONFLICT DO NOTHING;
INSERT INTO "content_manager" ("id", "key", "value", "type", "updated_by", "created_at", "updated_at") VALUES (4, 'stat_tahun', '7th', 'text', NULL, '2026-08-17 23:50:18', '2026-08-17 23:50:18') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: sqr_notifications
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "sqr_notifications" (
    "id" BIGSERIAL PRIMARY KEY,
    "user_id" BIGINT,
    "title" TEXT NOT NULL,
    "message" TEXT NOT NULL,
    "is_read" BIGINT NOT NULL DEFAULT 0,
    "type" TEXT NOT NULL DEFAULT 'info',
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE,
    "target_role" TEXT
);

-- Data for table: sqr_notifications
INSERT INTO "sqr_notifications" ("id", "user_id", "title", "message", "is_read", "type", "created_at", "updated_at", "target_role") VALUES (1, NULL, '💻 Pengumuman KBM Daring (Online) - Kelas Anak (Ummi 1 - 6)', 'Kelas Kelas Anak (Ummi 1 - 6) hari ini (20 Aug 2026) dilaksanakan secara DARING (Online Zoom/Meet) mulai pukul 16:00 WIB. Link Pertemuan: https://meet.google.com/test-link', 0, 'online_class', '2026-08-20 17:10:54', '2026-08-20 17:10:54', 'wali') ON CONFLICT DO NOTHING;
INSERT INTO "sqr_notifications" ("id", "user_id", "title", "message", "is_read", "type", "created_at", "updated_at", "target_role") VALUES (2, 3, '💻 KBM Daring (Online) - Kelas Anak (Ummi 1 - 6)', 'Kelas Kelas Anak (Ummi 1 - 6) hari ini dilaksanakan DARING di https://meet.google.com/sqr-online-class . Harap hadir tepat waktu.', 0, 'online_class', '2026-08-27 18:37:26', '2026-08-27 18:37:26', 'wali') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: audit_log
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "audit_log" (
    "id" BIGSERIAL PRIMARY KEY,
    "user_id" BIGINT,
    "action" TEXT NOT NULL,
    "model_type" TEXT,
    "model_id" BIGINT,
    "old_values" TEXT,
    "new_values" TEXT,
    "ip_address" TEXT,
    "user_agent" TEXT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- --------------------------------------------------------
-- Table Structure: articles
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "articles" (
    "id" BIGSERIAL PRIMARY KEY,
    "title" TEXT NOT NULL,
    "slug" TEXT NOT NULL,
    "excerpt" TEXT,
    "content" TEXT NOT NULL,
    "image_url" TEXT,
    "is_published" BIGINT NOT NULL DEFAULT 0,
    "published_at" TIMESTAMP WITHOUT TIME ZONE,
    "author_id" BIGINT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE,
    "category" TEXT NOT NULL DEFAULT 'Kegiatan',
    "media_url" TEXT
);

-- Data for table: articles
INSERT INTO "articles" ("id", "title", "slug", "excerpt", "content", "image_url", "is_published", "published_at", "author_id", "created_at", "updated_at", "category", "media_url") VALUES (1, 'Metode Pembelajaran Ummi Jilid 1-6 SQR', 'metode-pembelajaran-ummi-jilid-1-6-sqr', 'Panduan membaca Al-Quran terstruktur untuk anak-anak.', 'Metode Ummi merupakan salah satu metode pembelajaran Al-Quran terdepan yang menekankan pada kualitas bacaan tartil dan tajwid murni.', NULL, 1, '2026-09-04 05:37:09', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', 'Kegiatan', 'https://youtu.be/SNRYDkaVrms?si=2DrIKGt6J1xw04wW') ON CONFLICT DO NOTHING;
INSERT INTO "articles" ("id", "title", "slug", "excerpt", "content", "image_url", "is_published", "published_at", "author_id", "created_at", "updated_at", "category", "media_url") VALUES (2, 'Persiapan Santri Menghadapi Ramadhan 1447H', 'persiapan-santri-menghadapi-ramadhan-1447h', 'Panduan kedisiplinan dan murajaah di bulan Ramadhan.', 'Bulan suci Ramadhan adalah saat terbaik melipatgandakan murajaah hafalan Al-Quran santri.', NULL, 1, '2026-09-04 05:37:09', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', 'Kajian', 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?q=80&w=1200&auto=format&fit=crop') ON CONFLICT DO NOTHING;
INSERT INTO "articles" ("id", "title", "slug", "excerpt", "content", "image_url", "is_published", "published_at", "author_id", "created_at", "updated_at", "category", "media_url") VALUES (3, 'Pentingnya Peran Orang Tua Dalam Murajaah', 'pentingnya-peran-orang-tua-dalam-murajaah', 'Sinergi rumah dan lembaga Al-Quran.', 'Kunci keberhasilan hafalan santri yang mutqin adalah bimbingan dan simakan rutin dari orang tua di rumah.', NULL, 1, '2026-09-04 05:37:09', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', 'Parenting', 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?q=80&w=1200&auto=format&fit=crop') ON CONFLICT DO NOTHING;
INSERT INTO "articles" ("id", "title", "slug", "excerpt", "content", "image_url", "is_published", "published_at", "author_id", "created_at", "updated_at", "category", "media_url") VALUES (4, 'Keutamaan Menghafal Al-Quran Usia Dini', 'keutamaan-menghafal-al-quran-usia-dini', 'Memupuk kecintaan Al-Quran sejak kecil.', 'Anak-anak memiliki daya ingat yang sangat tajam untuk menyerap ayat-ayat suci Al-Quran.', NULL, 1, '2026-09-04 05:37:09', 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09', 'Kurikulum', 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=1200&auto=format&fit=crop') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: campaigns
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "campaigns" (
    "id" BIGSERIAL PRIMARY KEY,
    "title" TEXT NOT NULL,
    "slug" TEXT NOT NULL,
    "category" TEXT NOT NULL DEFAULT 'Sosial & Ta''awun',
    "target_amount" NUMERIC(15,2) NOT NULL DEFAULT 0,
    "current_amount" NUMERIC(15,2) NOT NULL DEFAULT 0,
    "excerpt" TEXT,
    "description" TEXT,
    "image_url" TEXT,
    "bank_name" TEXT NOT NULL DEFAULT 'Bank Syariah Indonesia (BSI)',
    "bank_account" TEXT NOT NULL DEFAULT '7289-0123-45',
    "bank_holder" TEXT NOT NULL DEFAULT 'Yayasan Bina Cahaya Ilmu Rabbani',
    "is_active" BIGINT NOT NULL DEFAULT 1,
    "end_date" DATE,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: campaigns
INSERT INTO "campaigns" ("id", "title", "slug", "category", "target_amount", "current_amount", "excerpt", "description", "image_url", "bank_name", "bank_account", "bank_holder", "is_active", "end_date", "created_at", "updated_at") VALUES (1, 'Program Jumat Berbagi & Ta''awun Santri', 'jumat-berbagi-taawun-santri', 'Program Rutin', 5000000, 4250000, 'Nasi berkah & makanan bergizi santri tiap Jumat.', 'Program santunan & konsumsi sehat untuk santri penghafal Quran.', 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1200&auto=format&fit=crop', 'Bank Syariah Indonesia (BSI)', '7289-0123-45', 'Yayasan Bina Cahaya Ilmu Rabbani', 1, NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "campaigns" ("id", "title", "slug", "category", "target_amount", "current_amount", "excerpt", "description", "image_url", "bank_name", "bank_account", "bank_holder", "is_active", "end_date", "created_at", "updated_at") VALUES (2, 'Wakaf 100 Mus-haf Al-Quran Hafalan', 'wakaf-100-mus-haf-al-quran-hafalan', 'Wakaf Quran', 8500000, 6800000, 'Pengadaan Al-Quran hafalan tajwid warna santri baru.', 'Sedekah jariyah Al-Quran untuk dibaca dan dihafal santri.', 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?q=80&w=1200&auto=format&fit=crop', 'Bank Syariah Indonesia (BSI)', '7289-0123-45', 'Yayasan Bina Cahaya Ilmu Rabbani', 1, NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "campaigns" ("id", "title", "slug", "category", "target_amount", "current_amount", "excerpt", "description", "image_url", "bank_name", "bank_account", "bank_holder", "is_active", "end_date", "created_at", "updated_at") VALUES (3, 'Renovasi Kelas & Karpet Sajadah SQR', 'renovasi-kelas-karpet-sajadah-sqr', 'Fasilitas', 12000000, 9500000, 'Pengadaan karpet tebal & AC pendingin kelas santri.', 'Meningkatkan kenyamanan kelas belajar santri.', 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?q=80&w=1200&auto=format&fit=crop', 'Bank Syariah Indonesia (BSI)', '7289-0123-45', 'Yayasan Bina Cahaya Ilmu Rabbani', 1, NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "campaigns" ("id", "title", "slug", "category", "target_amount", "current_amount", "excerpt", "description", "image_url", "bank_name", "bank_account", "bank_holder", "is_active", "end_date", "created_at", "updated_at") VALUES (4, 'Pembangunan Ruang Kelas Tahfidz SQR Utama', 'pembangunan-ruang-kelas-tahfidz-sqr', 'Pembangunan & Fasilitas', 50000000, 12500000, 'Bantu wujudkan kelas nyaman untuk para penghafal Al-Quran.', 'Program renovasi dan penambahan 2 ruang kelas belajar santri.', 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1200&auto=format&fit=crop', 'Bank Syariah Indonesia (BSI)', '7289-0123-45', 'Yayasan Bina Cahaya Ilmu Rabbani', 1, NULL, '2026-08-20 17:36:24', '2026-08-20 17:36:24') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: galleries
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "galleries" (
    "id" BIGSERIAL PRIMARY KEY,
    "title" TEXT NOT NULL,
    "category" TEXT NOT NULL DEFAULT 'KBM Santri',
    "image_url" TEXT NOT NULL,
    "description" TEXT,
    "event_date" DATE,
    "is_featured" BIGINT NOT NULL DEFAULT 1,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: galleries
INSERT INTO "galleries" ("id", "title", "category", "image_url", "description", "event_date", "is_featured", "created_at", "updated_at") VALUES (1, 'Kegiatan KBM Santri Ummi Jilid 1-6', 'KBM Santri', 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=1200&auto=format&fit=crop', 'Bimbingan privat baca Al-Quran santri anak.', NULL, 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "galleries" ("id", "title", "category", "image_url", "description", "event_date", "is_featured", "created_at", "updated_at") VALUES (2, 'Setoran Hafalan Tahfidz Remaja', 'KBM Santri', 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?q=80&w=1200&auto=format&fit=crop', 'Ujian mutqin Juz 30 santri remaja SQR.', NULL, 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "galleries" ("id", "title", "category", "image_url", "description", "event_date", "is_featured", "created_at", "updated_at") VALUES (3, 'Penyaluran Paket Jumat Berbagi Santri', 'Donasi', 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1200&auto=format&fit=crop', 'Pembagian hidangan Jumat berkah santri.', NULL, 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "galleries" ("id", "title", "category", "image_url", "description", "event_date", "is_featured", "created_at", "updated_at") VALUES (4, 'Sanlat Ramadhan & Mabit Santri', 'Sanlat', 'https://images.unsplash.com/photo-1519817650390-64a93db51149?q=80&w=1200&auto=format&fit=crop', 'Pesantren kilat Ramadhan & Mabit.', NULL, 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "galleries" ("id", "title", "category", "image_url", "description", "event_date", "is_featured", "created_at", "updated_at") VALUES (5, 'Kajian Tematik Parenting Quran', 'Kajian', 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?q=80&w=1200&auto=format&fit=crop', 'Kajian bulanan wali santri bersama pengasuh.', NULL, 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "galleries" ("id", "title", "category", "image_url", "description", "event_date", "is_featured", "created_at", "updated_at") VALUES (6, 'Wisuda & Haflah Akhir Sanah Tahfidz', 'Wisuda', 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1200&auto=format&fit=crop', 'Haflah wisuda kelulusan santri mutqin.', NULL, 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: donations
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "donations" (
    "id" BIGSERIAL PRIMARY KEY,
    "campaign_id" BIGINT NOT NULL,
    "donor_name" TEXT NOT NULL,
    "donor_phone" TEXT,
    "donor_email" TEXT,
    "amount" NUMERIC(15,2) NOT NULL,
    "payment_method" TEXT NOT NULL DEFAULT 'Transfer Bank BSI',
    "status" TEXT NOT NULL DEFAULT 'Paid',
    "notes" TEXT,
    "proof_image" TEXT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: donations
INSERT INTO "donations" ("id", "campaign_id", "donor_name", "donor_phone", "donor_email", "amount", "payment_method", "status", "notes", "proof_image", "created_at", "updated_at") VALUES (1, 1, 'H. Abdullah', 081299001122, 'abdullah@gmail.com', 1000000, 'Transfer BSI', 'Paid', 'Wakaf nasi berkah Jumat', NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "donations" ("id", "campaign_id", "donor_name", "donor_phone", "donor_email", "amount", "payment_method", "status", "notes", "proof_image", "created_at", "updated_at") VALUES (2, 1, 'Hj. Siti Rahmah', 081299001133, 'sitirahmah@gmail.com', 1500000, 'Transfer Mandiri', 'Paid', 'Infaq snack santri', NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "donations" ("id", "campaign_id", "donor_name", "donor_phone", "donor_email", "amount", "payment_method", "status", "notes", "proof_image", "created_at", "updated_at") VALUES (3, 2, 'Bpk. Hendra Wijaya', 081299001144, 'hendraw@gmail.com', 2000000, 'QRIS BSI', 'Paid', 'Wakaf 20 Al-Quran hafalan', NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "donations" ("id", "campaign_id", "donor_name", "donor_phone", "donor_email", "amount", "payment_method", "status", "notes", "proof_image", "created_at", "updated_at") VALUES (4, 3, 'Hamba Allah', 081299001155, 'donatur@gmail.com', 3000000, 'Transfer BSI', 'Paid', 'Donasi karpet kelas', NULL, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: ustadz_attendance
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "ustadz_attendance" (
    "id" BIGSERIAL PRIMARY KEY,
    "ustadz_id" BIGINT NOT NULL,
    "date" DATE NOT NULL,
    "status" TEXT NOT NULL DEFAULT 'Hadir',
    "check_in_time" TEXT,
    "notes" TEXT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE,
    "substitute_ustadz_id" BIGINT,
    "online_meeting_link" TEXT,
    "online_start_time" TEXT,
    "latitude" NUMERIC(15,2),
    "longitude" NUMERIC(15,2),
    "distance_meters" BIGINT,
    "is_within_radius" BIGINT NOT NULL DEFAULT 1
);

-- Data for table: ustadz_attendance
INSERT INTO "ustadz_attendance" ("id", "ustadz_id", "date", "status", "check_in_time", "notes", "created_at", "updated_at", "substitute_ustadz_id", "online_meeting_link", "online_start_time", "latitude", "longitude", "distance_meters", "is_within_radius") VALUES (1, 2, '2026-08-17 00:00:00', 'Hadir', '23:54:08', NULL, '2026-08-17 23:54:08', '2026-08-17 23:54:08', NULL, NULL, NULL, NULL, NULL, NULL, 1) ON CONFLICT DO NOTHING;
INSERT INTO "ustadz_attendance" ("id", "ustadz_id", "date", "status", "check_in_time", "notes", "created_at", "updated_at", "substitute_ustadz_id", "online_meeting_link", "online_start_time", "latitude", "longitude", "distance_meters", "is_within_radius") VALUES (2, 2, '2026-08-18 00:00:00', 'Hadir', '06:58:14', NULL, '2026-08-18 06:58:14', '2026-08-18 06:58:14', NULL, NULL, NULL, NULL, NULL, NULL, 1) ON CONFLICT DO NOTHING;
INSERT INTO "ustadz_attendance" ("id", "ustadz_id", "date", "status", "check_in_time", "notes", "created_at", "updated_at", "substitute_ustadz_id", "online_meeting_link", "online_start_time", "latitude", "longitude", "distance_meters", "is_within_radius") VALUES (3, 2, '2026-08-20 00:00:00', 'Izin', '17:13:17', 'Otomatis ALPA oleh sistem (melewati batas jam presensi ustadz 16:15 WIB)', '2026-08-20 16:18:41', '2026-08-20 17:13:17', NULL, 'https://meet.google.com/test-link', '16:00', '-6.3937325', 106.8782665, 442, 1) ON CONFLICT DO NOTHING;
INSERT INTO "ustadz_attendance" ("id", "ustadz_id", "date", "status", "check_in_time", "notes", "created_at", "updated_at", "substitute_ustadz_id", "online_meeting_link", "online_start_time", "latitude", "longitude", "distance_meters", "is_within_radius") VALUES (4, 4, '2026-08-20 00:00:00', 'Hadir', '08:00:00', 'Presensi HADIR Ustadzah Pengganti Aktif Hari Ini', '2026-08-20 16:43:50', '2026-08-20 16:43:50', NULL, NULL, NULL, NULL, NULL, NULL, 1) ON CONFLICT DO NOTHING;
INSERT INTO "ustadz_attendance" ("id", "ustadz_id", "date", "status", "check_in_time", "notes", "created_at", "updated_at", "substitute_ustadz_id", "online_meeting_link", "online_start_time", "latitude", "longitude", "distance_meters", "is_within_radius") VALUES (5, 2, '2026-08-27 00:00:00', 'Hadir', '18:20:53', 'KBM Tatap Muka SQR Utama', '2026-08-27 18:20:53', '2026-08-27 18:37:26', NULL, 'https://meet.google.com/sqr-online-class', '16:00', NULL, NULL, NULL, 1) ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: santri_attendance
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "santri_attendance" (
    "id" BIGSERIAL PRIMARY KEY,
    "santri_id" BIGINT NOT NULL,
    "class_id" BIGINT NOT NULL,
    "date" DATE NOT NULL,
    "status" TEXT NOT NULL DEFAULT 'Hadir',
    "recorded_by" BIGINT,
    "notes" TEXT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE,
    "substitute_ustadz_id" BIGINT
);

-- Data for table: santri_attendance
INSERT INTO "santri_attendance" ("id", "santri_id", "class_id", "date", "status", "recorded_by", "notes", "created_at", "updated_at", "substitute_ustadz_id") VALUES (1, 2, 1, '2026-08-18 00:00:00', 'Hadir', 2, NULL, '2026-08-18 07:05:46', '2026-08-18 07:05:46', NULL) ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: organization_settings
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "organization_settings" (
    "id" BIGSERIAL PRIMARY KEY,
    "key" TEXT NOT NULL,
    "value" TEXT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: organization_settings
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (1, 'organization_name', 'Saung Quran Rabbani', '2026-08-20 14:16:11', '2026-08-20 14:16:11') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (2, 'organization_subtitle', 'Lembaga Pendidikan Al-Qur''an Terpadu', '2026-08-20 14:16:11', '2026-08-20 14:16:11') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (3, 'organization_address', 'Jl. Rabbani No. 1, Bogor, Jawa Barat', '2026-08-20 14:16:11', '2026-08-20 14:16:11') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (4, 'organization_phone', 081292831231, '2026-08-20 14:16:11', '2026-08-20 14:36:27') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (5, 'organization_email', 'info@sqr.id', '2026-08-20 14:16:11', '2026-08-20 14:16:11') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (6, 'organization_city', 'Depok', '2026-08-20 14:16:11', '2026-08-20 14:37:30') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (7, 'pimpinan_name', 'Hendri', '2026-08-20 14:16:11', '2026-08-20 14:36:27') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (8, 'pimpinan_title', 'Pembina Yayasan Saung Quran Rabbani', '2026-08-20 14:16:11', '2026-08-20 14:37:03') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (9, 'pimpinan_signature_url', 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png', '2026-08-20 14:16:11', '2026-08-20 14:36:27') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (10, 'organization_stamp_url', 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211358/stempel-removebg-preview_jkff7n.png', '2026-08-20 14:16:11', '2026-08-20 14:36:27') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (11, 'organization_logo_url', 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1782638700/logo_sqr_atzzpb.png', '2026-08-20 14:16:11', '2026-08-20 14:16:11') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (12, 'certificate_footer_text', 'Sertifikat ini dikeluarkan secara resmi oleh Saung Quran Rabbani dan dapat diverifikasi melalui pengurus lembaga.', '2026-08-20 14:16:11', '2026-08-20 14:16:11') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (13, 'yayasan_logo_url', 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787212253/WhatsApp_Image_2024-03-05_at_16.45.18__1_-removebg-preview_1_n7ggrp.png', '2026-08-20 14:51:51', '2026-08-20 14:51:51') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (14, 'ustadz_signature_url', '', '2026-08-20 14:51:51', '2026-08-20 14:51:51') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (15, 'org_name', 'Yayasan Bina Cahaya Ilmu Rabbani (SQR)', '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (16, 'org_address', 'Jl. Puri Kemang Permai No.85, RT.002/008, Sukatani, Tapos Depok', '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (17, 'org_phone', 081293721163, '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (18, 'org_email', 'admin@sqr.id', '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (19, 'pembina_name', 'Ust. Ahmad Fauzi', '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (20, 'pembina_title', 'Kepala Pengasuh Saung Quran Rabbani', '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (21, 'taruna_rate_physical', 50000, '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (22, 'taruna_rate_online', 25000, '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (23, 'taruna_incentive_sub', 15000, '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (24, 'sqr_latitude', '-6.393733', '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (25, 'sqr_longitude', 106.878266, '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "organization_settings" ("id", "key", "value", "created_at", "updated_at") VALUES (26, 'sqr_radius_meters', 30, '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: school_schedules
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "school_schedules" (
    "id" BIGSERIAL PRIMARY KEY,
    "key" TEXT NOT NULL,
    "value" TEXT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: school_schedules
INSERT INTO "school_schedules" ("id", "key", "value", "created_at", "updated_at") VALUES (1, 'jam_masuk', '16:00', '2026-08-20 15:28:07', '2026-08-20 15:56:44') ON CONFLICT DO NOTHING;
INSERT INTO "school_schedules" ("id", "key", "value", "created_at", "updated_at") VALUES (2, 'jam_pulang', '17:30', '2026-08-20 15:28:07', '2026-08-20 15:56:44') ON CONFLICT DO NOTHING;
INSERT INTO "school_schedules" ("id", "key", "value", "created_at", "updated_at") VALUES (3, 'libur_mingguan', '6,0', '2026-08-20 15:28:07', '2026-08-20 15:56:44') ON CONFLICT DO NOTHING;
INSERT INTO "school_schedules" ("id", "key", "value", "created_at", "updated_at") VALUES (4, 'nama_sekolah', 'Saung Quran Rabbani', '2026-08-20 15:28:07', '2026-08-20 15:28:07') ON CONFLICT DO NOTHING;
INSERT INTO "school_schedules" ("id", "key", "value", "created_at", "updated_at") VALUES (5, 'kelas_mulai_tanggal', '2026-01-01', '2026-08-20 15:28:07', '2026-08-20 15:28:07') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: school_events
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "school_events" (
    "id" BIGSERIAL PRIMARY KEY,
    "date" DATE NOT NULL,
    "date_end" DATE,
    "title" TEXT NOT NULL,
    "description" TEXT,
    "type" TEXT NOT NULL DEFAULT 'pengumuman',
    "is_holiday" BIGINT NOT NULL DEFAULT 0,
    "online_link" TEXT,
    "online_start_time" TEXT,
    "class_id" BIGINT,
    "created_by" BIGINT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

-- Data for table: school_events
INSERT INTO "school_events" ("id", "date", "date_end", "title", "description", "type", "is_holiday", "online_link", "online_start_time", "class_id", "created_by", "created_at", "updated_at") VALUES (1, '2026-08-25', '2026-08-27', 'Ujian Munaqosyah Ummi & Tahfidz', 'Pelaksanaan ujian kelulusan Jilid Ummi & Tahfidz Juz 30', 'acara', 0, NULL, NULL, NULL, 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "school_events" ("id", "date", "date_end", "title", "description", "type", "is_holiday", "online_link", "online_start_time", "class_id", "created_by", "created_at", "updated_at") VALUES (2, '2026-08-30', '2026-08-30', 'Haflah Wisuda Santri Mutqin 1447H', 'Acara puncak penyerahan sertifikat & mahkota wisudawan', 'acara', 0, NULL, NULL, NULL, 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "school_events" ("id", "date", "date_end", "title", "description", "type", "is_holiday", "online_link", "online_start_time", "class_id", "created_by", "created_at", "updated_at") VALUES (3, '2026-09-05', '2026-09-05', 'Kajian Bulanan & Pembagian Rapor Santri', 'Pertemuan silaturahmi wali santri & penerimaan rapor', 'pengumuman', 0, NULL, NULL, NULL, 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "school_events" ("id", "date", "date_end", "title", "description", "type", "is_holiday", "online_link", "online_start_time", "class_id", "created_by", "created_at", "updated_at") VALUES (4, '2026-09-15', '2026-09-20', 'Sanlat Ramadhan & I''tikaf Santri', 'Kegiatan intensif penghafal Quran di bulan Ramadhan', 'acara', 0, NULL, NULL, NULL, 1, '2026-09-04 05:37:09', '2026-09-04 05:37:09') ON CONFLICT DO NOTHING;
INSERT INTO "school_events" ("id", "date", "date_end", "title", "description", "type", "is_holiday", "online_link", "online_start_time", "class_id", "created_by", "created_at", "updated_at") VALUES (5, '2026-09-17 00:00:00', NULL, 'Libur Kemerdekaan RI ke-81', 'Memperingati Hari Kemerdekaan Republik Indonesia, kegiatan belajar mengajar diliburkan.', 'libur', 1, NULL, NULL, NULL, 1, '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "school_events" ("id", "date", "date_end", "title", "description", "type", "is_holiday", "online_link", "online_start_time", "class_id", "created_by", "created_at", "updated_at") VALUES (6, '2026-09-07 00:00:00', NULL, 'Kajian Parenting & Quran Bulan Ini', 'Kajian bulanan khusus Wali Santri bersama Pembina Yayasan. Harap hadir pukul 16:00 WIB.', 'acara', 0, NULL, NULL, NULL, 1, '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "school_events" ("id", "date", "date_end", "title", "description", "type", "is_holiday", "online_link", "online_start_time", "class_id", "created_by", "created_at", "updated_at") VALUES (7, '2026-09-11 00:00:00', NULL, 'Kelas Online Pengganti (Zoom)', 'Kelas online via Zoom menggantikan pertemuan tatap muka.', 'online', 0, 'https://meet.google.com/sqr-online-001', '16:00:00', NULL, 1, '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;
INSERT INTO "school_events" ("id", "date", "date_end", "title", "description", "type", "is_holiday", "online_link", "online_start_time", "class_id", "created_by", "created_at", "updated_at") VALUES (8, '2026-09-16 00:00:00', '2026-09-18 00:00:00', 'Pesantren Kilat & Mabit Santri', 'Kegiatan Sanlat dan Malam Bina Iman Taqwa (MABIT) untuk seluruh santri SQR.', 'acara', 0, NULL, NULL, NULL, 1, '2026-09-04 12:32:07', '2026-09-04 12:32:07') ON CONFLICT DO NOTHING;

-- --------------------------------------------------------
-- Table Structure: ustadz_payroll_bonuses
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS "ustadz_payroll_bonuses" (
    "id" BIGSERIAL PRIMARY KEY,
    "ustadz_id" BIGINT NOT NULL,
    "month" BIGINT NOT NULL,
    "year" BIGINT NOT NULL,
    "bonus_amount" NUMERIC(15,2) NOT NULL DEFAULT 0,
    "bonus_note" TEXT,
    "created_by" BIGINT,
    "created_at" TIMESTAMP WITHOUT TIME ZONE,
    "updated_at" TIMESTAMP WITHOUT TIME ZONE
);

