<?php

namespace App\Http\Controllers;

use App\Http\Requests\BadgeRequest;
use App\Services\BadgeService;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Create Badge',
        ];
        return view('admin.badges.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BadgeRequest $request)
    {
        $this->badgeService->createBadge($request->validated());
        return redirect()->route('badges.index')->with('success', 'Badge created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Badge',
            'badge' => $this->badgeService->getBadgeById($id),
        ];
        return view('admin.badges.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BadgeRequest $request, string $id)
    {
        $this->badgeService->updateBadge($id, $request->validated());
        return redirect()->route('badges.index')->with('success', 'Badge updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->badgeService->deleteBadge($id);
        return redirect()->route('badges.index')->with('success', 'Badge deleted successfully.');
    }
}
