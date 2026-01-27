<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\AddonRepositoryInterface;

class AddonController extends Controller
{
    protected $addonRepository;

    public function __construct(AddonRepositoryInterface $addonRepository)
    {
        $this->addonRepository = $addonRepository;
    }

    public function index()
    {
        $addons = $this->addonRepository->getAllAddons();
        return view('super-admin.pages.addons.index', compact('addons'));
    }

    public function create()
    {
        return view('super-admin.pages.addons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:addons,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $this->addonRepository->createAddon($validated);

        return redirect()->route('super-admin.addons.index')
            ->with('success', 'Addon created successfully');
    }

    public function edit($id)
    {
        $addon = $this->addonRepository->getAddonById($id);
        return view('super-admin.pages.addons.edit', compact('addon'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:addons,slug,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $this->addonRepository->updateAddon($id, $validated);

        return redirect()->route('super-admin.addons.index')
            ->with('success', 'Addon updated successfully');
    }

    public function destroy($id)
    {
        try {
            $this->addonRepository->deleteAddon($id);
            return redirect()->route('super-admin.addons.index')
                ->with('success', 'Addon deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('super-admin.addons.index')
                ->with('error', 'Cannot delete addon in use');
        }
    }

    public function toggleStatus($id)
    {
        $addon = $this->addonRepository->toggleAddonStatus($id);
        $status = $addon->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('super-admin.addons.index')
            ->with('success', "Addon {$status} successfully");
    }
}
