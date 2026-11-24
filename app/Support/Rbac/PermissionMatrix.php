<?php

namespace App\Support\Rbac;

/**
 * Single source of truth for SIPERDIN's internal roles and permissions.
 * Guest is intentionally not an application role; public routes are anonymous.
 */
final class PermissionMatrix
{
    public const GUARD = 'web';

    /** @return array<string, string> */
    public static function roles(): array
    {
        return [
            'Superadmin' => 'Mengelola akun dan hak akses, data master, monitoring lintas satuan kerja, serta audit aktivitas sistem.',
            'Operator Data' => 'Mengelola data master pegawai, satuan kerja, tempat perjalanan, SBM, dan template dokumen.',
            'Operator Satker' => 'Mengelola proses perjalanan dinas dan dokumen pertanggungjawaban pada satuan kerja yang menjadi kewenangannya.',
            'Admin Keuangan' => 'Memverifikasi pengajuan, mengelola pencairan, dan melakukan finalisasi perjalanan dinas pada satuan kerja yang menjadi kewenangannya.',
        ];
    }

    /** @return array<string, string> */
    public static function permissions(): array
    {
        return [
            // Shared internal access.
            'dashboard.view' => 'Mengakses dashboard internal sesuai role dan cakupan data pengguna.',

            // FR-03: account administration is reserved for Superadmin.
            'users.view' => 'Melihat daftar akun pengguna internal.',
            'users.create' => 'Membuat akun pengguna internal.',
            'users.update' => 'Memperbarui informasi akun pengguna.',
            'users.assign-role' => 'Menetapkan role internal kepada akun pengguna.',
            'users.set-status' => 'Mengubah status aktif atau nonaktif akun pengguna.',
            'users.reset-password' => 'Mereset password akun pengguna lain sebagai administrator.',

            // FR-04 to FR-08: master data.
            'master-data.view' => 'Melihat data master sistem.',
            'master-data.create' => 'Menambahkan data master sistem.',
            'master-data.update' => 'Memperbarui data master sistem.',
            'master-data.delete' => 'Menghapus atau menonaktifkan data master melalui aksi yang tersedia.',

            // FR-09 to FR-15: travel grouping, employee detail, assignment and post-trip data.
            'travel.grouping.view' => 'Melihat grouping perjalanan dinas pada satuan kerja pengguna.',
            'travel.grouping.create' => 'Membuat grouping perjalanan dinas pada satuan kerja pengguna.',
            'travel.grouping.update' => 'Memperbarui grouping perjalanan dinas pada satuan kerja pengguna.',
            'travel.detail.manage' => 'Mengelola detail perjalanan masing-masing pegawai.',
            'travel.assignment-documents.generate' => 'Menghasilkan Nota Dinas dan Surat Perjalanan Dinas.',
            'travel.post-trip.manage' => 'Mengelola data administrasi setelah perjalanan dinas dilaksanakan.',

            // FR-16 to FR-18: supporting documents and AI extraction.
            'supporting-documents.view' => 'Melihat dokumen transaksi pendukung perjalanan dinas.',
            'supporting-documents.upload' => 'Mengunggah dokumen transaksi pendukung perjalanan dinas.',
            'ai-extraction.view' => 'Melihat status dan hasil ekstraksi informasi dokumen.',
            'ai-extraction.run' => 'Menjalankan ekstraksi informasi dokumen melalui layanan Generative AI.',
            'ai-extraction.correct' => 'Mencatat koreksi pengguna secara terpisah dari hasil ekstraksi asli.',

            // FR-19 to FR-22: accountability drafts, validation and submission.
            'accountability-drafts.view' => 'Melihat draf dokumen pertanggungjawaban.',
            'accountability-drafts.generate' => 'Menghasilkan draf dokumen pertanggungjawaban berdasarkan data sistem.',
            'accountability-drafts.update' => 'Menyunting field draf yang diperbolehkan dan membuat versi dokumen baru.',
            'accountability-drafts.validate' => 'Memvalidasi setiap draf dokumen pertanggungjawaban.',
            'travel.submit' => 'Mengajukan perjalanan dinas setelah seluruh dokumen wajib divalidasi.',

            // FR-23 to FR-30: monitoring, finance verification, revision and finalization.
            'travel.monitor.satker' => 'Memantau perjalanan dinas pada satuan kerja pengguna.',
            'travel.monitor.all' => 'Memantau perjalanan dinas lintas satuan kerja.',
            'submissions.view' => 'Melihat daftar pengajuan yang perlu ditindaklanjuti oleh Admin Keuangan.',
            'submissions.verify' => 'Memverifikasi kelengkapan dan kesesuaian pengajuan perjalanan dinas.',
            'submissions.return' => 'Mengembalikan pengajuan dengan catatan perbaikan.',
            'submissions.revise' => 'Memperbaiki data dan dokumen atas pengajuan yang dikembalikan.',
            'payouts.manage' => 'Mencatat informasi pencairan dan mengarsipkan dokumen hasil pencairan.',
            'travel.finalize' => 'Melakukan finalisasi administrasi dan menyelesaikan perjalanan dinas.',

            // FR-31 is automatic; FR-32 is visible only to Superadmin.
            'activity-log.view' => 'Melihat dan menelusuri riwayat aktivitas pengguna untuk audit sistem.',
        ];
    }

    /** @return array<string, list<string>> */
    public static function rolePermissions(): array
    {
        return [
            'Superadmin' => [
                'dashboard.view',
                'users.view',
                'users.create',
                'users.update',
                'users.assign-role',
                'users.set-status',
                'users.reset-password',
                'master-data.view',
                'master-data.create',
                'master-data.update',
                'master-data.delete',
                'travel.monitor.all',
                'activity-log.view',
            ],
            'Operator Data' => [
                'dashboard.view',
                'master-data.view',
                'master-data.create',
                'master-data.update',
                'master-data.delete',
            ],
            'Operator Satker' => [
                'dashboard.view',
                'travel.grouping.view',
                'travel.grouping.create',
                'travel.grouping.update',
                'travel.detail.manage',
                'travel.assignment-documents.generate',
                'travel.post-trip.manage',
                'supporting-documents.view',
                'supporting-documents.upload',
                'ai-extraction.view',
                'ai-extraction.run',
                'ai-extraction.correct',
                'accountability-drafts.view',
                'accountability-drafts.generate',
                'accountability-drafts.update',
                'accountability-drafts.validate',
                'travel.submit',
                'submissions.revise',
                'travel.monitor.satker',
            ],
            'Admin Keuangan' => [
                'dashboard.view',
                'submissions.view',
                'submissions.verify',
                'submissions.return',
                'payouts.manage',
                'travel.finalize',
                'travel.monitor.satker',
            ],
        ];
    }

    /** @return list<string> */
    public static function legacyPermissionNames(): array
    {
        return [
            'view users',
            'create users',
            'update users',
            'delete users',
            'assign roles',
            'manage master data',
            'view master data',
            'create master data',
            'update master data',
            'delete master data',
            'create travel',
            'view own travel',
            'view all travel',
            'update travel',
            'delete travel',
            'verify travel',
            'add finance data',
            'complete travel',
            'generate travel document',
            'generate finance document',
            'view reports',
            'export reports',
        ];
    }
}
