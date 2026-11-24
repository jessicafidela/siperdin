<?php

namespace App\Policies;

use App\Models\PerjalananDinas;
use App\Models\User;

class PerjalananDinasPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('travel.monitor.all')
            || $user->can('travel.monitor.satker')
            || $user->can('travel.grouping.view');
    }

    public function view(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $this->canMonitor($user)
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function create(User $user): bool
    {
        return $user->can('travel.grouping.create')
            && $user->satkerId() !== null;
    }

    public function update(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('travel.grouping.update')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function manageDetails(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('travel.detail.manage')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function generateAssignmentDocuments(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('travel.assignment-documents.generate')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function managePostTrip(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('travel.post-trip.manage')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function viewSupportingDocuments(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('supporting-documents.view')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function uploadSupportingDocuments(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('supporting-documents.upload')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function viewExtraction(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('ai-extraction.view')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function runExtraction(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('ai-extraction.run')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function correctExtraction(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('ai-extraction.correct')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function viewDrafts(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('accountability-drafts.view')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function generateDraft(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('accountability-drafts.generate')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function updateDraft(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('accountability-drafts.update')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function validateDraft(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('accountability-drafts.validate')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function submit(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('travel.submit')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function revise(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('submissions.revise')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function verify(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('submissions.verify')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function returnForRevision(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('submissions.return')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function managePayout(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('payouts.manage')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    public function finalize(User $user, PerjalananDinas $perjalananDinas): bool
    {
        return $user->can('travel.finalize')
            && $user->canAccessSatker($perjalananDinas->id_satker);
    }

    private function canMonitor(User $user): bool
    {
        return $user->can('travel.monitor.all')
            || $user->can('travel.monitor.satker')
            || $user->can('travel.grouping.view');
    }
}
