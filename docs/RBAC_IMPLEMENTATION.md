# SIPERDIN — Audit and RBAC implementation

## 1. Approved actors

SIPERDIN has four authenticated internal roles:

1. `Superadmin`
2. `Operator Data`
3. `Operator Satker`
4. `Admin Keuangan`

`Guest` is not a Spatie role. A visitor is represented by unauthenticated access to the public landing page (`GET /`). The role seeder removes the legacy `Guest` role if it was created by an earlier seed run.

## 2. Permission assignment

The canonical permission catalogue and role mapping are maintained in `app/Support/Rbac/PermissionMatrix.php`.

| Area | Superadmin | Operator Data | Operator Satker | Admin Keuangan |
|---|---|---|---|---|
| Dashboard | All internal summary | Master-data summary | Own satker summary | Own satker summary |
| User accounts and role assignment | Yes | No | No | No |
| Master data | Yes | Yes | No | No |
| Grouping and employee travel details | Monitor only | No | Own satker | No |
| Assignment documents (Nota Dinas / SPD) | No | No | Own satker | No |
| Post-trip data and supporting documents | No | No | Own satker | No |
| AI extraction and user corrections | No | No | Own satker | No |
| Accountability drafts and validation | No | No | Own satker | No |
| Submit and revise returned submission | No | No | Own satker | No |
| Verify and return submission | No | No | No | Own satker |
| Payout and finalization | No | No | No | Own satker |
| Travel monitoring | All satkers | No | Own satker | Own satker |
| Activity log | Yes | No | No | No |

Superadmin is not a wildcard role. It does not receive operational permissions to create/validate travel, verify submissions, manage payout, or finalize travel. This preserves the division of responsibility between Operator Satker and Admin Keuangan.

## 3. Route protection

- All internal routes require `auth` and `active` middleware.
- Dashboard requires `dashboard.view`.
- Master-data resource actions are separated into `master-data.view`, `master-data.create`, `master-data.update`, and `master-data.delete`.
- User routes require their specific `users.*` permissions. The user resource does not expose a delete route.
- The administrator password-reset route requires `users.reset-password`.
- The public landing page does not require authentication or a Guest role.

## 4. Satker-level row access

`User::satkerId()` resolves the satker through `users.id_pegawai` → `pegawai.id_satker`.

`User::canAccessSatker($id)` permits:

- Superadmin to access any satker for monitoring only.
- Operator Satker and Admin Keuangan to access only their linked satker.
- Operator Data and users without the required satker-monitor permission to access no travel record through this scope.

For travel list queries, use:

```php
PerjalananDinas::query()
    ->visibleTo($request->user())
    ->latest('id_perjalanan')
    ->get();
```

For an individual travel record or action, authorize through the registered `PerjalananDinasPolicy`, for example:

```php
$this->authorize('verify', $perjalananDinas);
$this->authorize('submit', $perjalananDinas);
```

The policy exposes separate actions for draft validation, submission, revision, verification, return, payout, and finalization. Child-record queries must be constrained through their parent `PerjalananDinas` record; do not authorize child records by their IDs alone.

## 5. Seeder behavior

`php artisan db:seed` will:

- Create/update the four approved internal roles.
- Remove the legacy `Guest` role.
- Create/update the canonical permission catalogue and descriptions.
- Remove the earlier coarse permission names (`view users`, `manage master data`, `verify travel`, etc.).
- Synchronize each internal role to the approved permission list, removing stale assignments.
- Preserve existing user accounts. The existing bootstrap Superadmin seeder remains environment-driven and does not overwrite an existing password.

No migration is added or modified by this RBAC patch. Do not run `migrate:fresh` for this patch.

## 6. Audit findings outside this RBAC patch

The uploaded project archive contains several incomplete areas that are not silently represented as finished by this patch:

- `UserController` create/store/edit/update actions are still stubs, and `resources/views/user/index.blade.php`, `create.blade.php`, and `edit.blade.php` are empty. The routes are protected, but the full account-management interface still needs implementation.
- Travel workflow controllers/routes are not yet present. The permission matrix, `PerjalananDinas` model, satker query scope, and policy prepare the authorization layer for those modules; they do not claim the complete workflow is already implemented.
- Some existing master-data Blade templates use older route names such as `satker.*`, `place.*`, and `sbm.*`, while current resource routes are named `satuan-kerja.*`, `tempat.*`, and `standar-biaya-masukan.*`. This is a separate view/controller integration issue.

These gaps should be addressed in the relevant module implementation stage, not bypassed by broad permissions.
