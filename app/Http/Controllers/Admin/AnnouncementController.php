<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user_id admin yang membuat
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $announcements = Announcement::with('author')->latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'), ['title' => 'Manajemen Pengumuman']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.announcements.create', ['title' => 'Buat Pengumuman Baru']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->only(['title', 'content', 'published_at']);
        $data['user_id'] = Auth::id(); // ID admin yang sedang login
        $data['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : false; // default false jika tidak ada
        if (empty($data['published_at']) && $data['is_active']) {
            $data['published_at'] = now(); // Jika aktif tapi tanggal publish kosong, set ke sekarang
        }


        Announcement::create($data);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Pengumuman berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     * (Bisa digunakan untuk preview oleh admin)
     */
    public function show(Announcement $announcement): View
    {
        return view('admin.announcements.show', compact('announcement'), ['title' => 'Detail Pengumuman']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement): View
    {
        return view('admin.announcements.edit', compact('announcement'), ['title' => 'Edit Pengumuman']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->only(['title', 'content', 'published_at']);
        // user_id tidak diubah karena pengedit tetap dianggap author awal
        $data['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : false;
        if (empty($data['published_at']) && $data['is_active'] && !$announcement->published_at) {
            $data['published_at'] = now(); // Jika diaktifkan dan belum pernah publish, set tanggal publish
        } elseif (!$data['is_active']) {
            // Jika dinonaktifkan, tanggal publish bisa di-null kan atau dibiarkan (tergantung kebutuhan)
            // $data['published_at'] = null;
        }


        $announcement->update($data);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Pengumuman berhasil dihapus.');
    }
}