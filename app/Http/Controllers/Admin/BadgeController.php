<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BadgeRequest;
use App\Services\BadgeService;

class BadgeController extends Controller
{
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    public function index()
    {
        $data = [
            'title' => 'Badge Management',
            'badges' => $this->badgeService->getAllBadges(),
        ];

        return view('admin.badges.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Badge',
        ];
        return view('admin.badges.create', $data);
    }

    public function store(BadgeRequest $request)
    {
        $this->badgeService->createBadge($request->validated());
        return redirect()->route('badges.index')->with('success', 'Badge created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Badge',
            'badge' => $this->badgeService->getBadgeById($id),
        ];
        return view('admin.badges.edit', $data);
    }

    public function update(BadgeRequest $request, string $id)
    {
        $this->badgeService->updateBadge($id, $request->validated());
        return redirect()->route('badges.index')->with('success', 'Badge updated successfully.');
    }

    public function destroy(string $id)
    {
        $this->badgeService->deleteBadge($id);
        return redirect()->route('badges.index')->with('success', 'Badge deleted successfully.');
    }
}
