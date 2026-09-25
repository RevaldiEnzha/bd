<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use App\Models\Memory;
use App\Models\BirthdaySetting;
use Illuminate\Http\Request;

class BirthdayController extends Controller
{
    protected function getThemeColors($themeName = 'strawberry')
    {
        $themes = [
            'strawberry' => [
                'name' => 'Strawberry Milkshake',
                'primary' => '#ff6b8b',
                'primary_light' => '#ffd6df',
                'secondary' => '#ff8da1',
                'accent' => '#ff477e',
                'bg_start' => '#fff0f3',
                'bg_mid' => '#ffe3e8',
                'bg_end' => '#ffd6df',
                'card_bg' => 'rgba(255, 255, 255, 0.94)',
                'text' => '#5c3d47',
                'text_soft' => '#8e6b77',
                'border' => '#ffb3c1',
                'shadow' => 'rgba(255, 107, 139, 0.22)'
            ],
            'peach' => [
                'name' => 'Peach Blossoms',
                'primary' => '#ff8e72',
                'primary_light' => '#ffe5d9',
                'secondary' => '#ffa07a',
                'accent' => '#ff6b4a',
                'bg_start' => '#fff8f0',
                'bg_mid' => '#ffeedd',
                'bg_end' => '#ffe5d9',
                'card_bg' => 'rgba(255, 255, 255, 0.94)',
                'text' => '#6b4b3e',
                'text_soft' => '#9e7869',
                'border' => '#ffcbb5',
                'shadow' => 'rgba(255, 142, 114, 0.22)'
            ],
            'lavender' => [
                'name' => 'Dreamy Lavender',
                'primary' => '#9d72ff',
                'primary_light' => '#eeddff',
                'secondary' => '#b388ff',
                'accent' => '#7c4dff',
                'bg_start' => '#f9f5ff',
                'bg_mid' => '#f2e8ff',
                'bg_end' => '#eeddff',
                'card_bg' => 'rgba(255, 255, 255, 0.94)',
                'text' => '#4c3e6b',
                'text_soft' => '#7b6d9e',
                'border' => '#d0bfff',
                'shadow' => 'rgba(157, 114, 255, 0.22)'
            ],
            'mint' => [
                'name' => 'Mint Vanilla',
                'primary' => '#48bca6',
                'primary_light' => '#d8f3ec',
                'secondary' => '#65cca9',
                'accent' => '#2cb698',
                'bg_start' => '#f2fbf8',
                'bg_mid' => '#e3f7f1',
                'bg_end' => '#d8f3ec',
                'card_bg' => 'rgba(255, 255, 255, 0.94)',
                'text' => '#325850',
                'text_soft' => '#5e857d',
                'border' => '#b4ebd9',
                'shadow' => 'rgba(72, 188, 166, 0.22)'
            ]
        ];

        return $themes[$themeName] ?? $themes['strawberry'];
    }

    protected function getSharedData()
    {
        $settings = BirthdaySetting::getAll();
        $themeColors = $this->getThemeColors($settings['theme'] ?? 'strawberry');

        return compact('settings', 'themeColors');
    }

    public function home()
    {
        return view('pages.home', $this->getSharedData());
    }

    public function cake()
    {
        return view('pages.cake', $this->getSharedData());
    }

    public function letter()
    {
        $data = $this->getSharedData();
        $settings = $data['settings'];

        // Replace placeholders
        $body = str_replace(
            ['{name}', '{age}', '{nickname}'],
            [$settings['name'] ?? 'Bidadari', $settings['age'] ?? '21', $settings['nickname'] ?? 'Manis'],
            $settings['letter_body'] ?? ''
        );
        $data['processedLetterBody'] = $body;

        return view('pages.letter', $data);
    }

    public function memories()
    {
        $data = $this->getSharedData();
        $data['memories'] = Memory::latest()->get();

        return view('pages.memories', $data);
    }

    public function wishes()
    {
        $data = $this->getSharedData();
        $data['wishes'] = Wish::latest()->get();

        return view('pages.wishes', $data);
    }

    public function game()
    {
        return view('pages.game', $this->getSharedData());
    }

    public function storeWish(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'message' => 'required|string|max:1000',
            'sticker' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:20',
        ]);

        $wish = Wish::create([
            'name' => $validated['name'],
            'message' => $validated['message'],
            'sticker' => $validated['sticker'] ?? '💖',
            'color' => $validated['color'] ?? 'pink',
            'likes' => 0
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'wish' => [
                    'id' => $wish->id,
                    'name' => $wish->name,
                    'message' => $wish->message,
                    'sticker' => $wish->sticker,
                    'color' => $wish->color,
                    'likes' => $wish->likes,
                    'time' => $wish->created_at->format('d M, H:i')
                ]
            ]);
        }

        return redirect()->route('wishes')->with('success', 'Doamu berhasil ditempelkan! 💖');
    }

    public function likeWish($id)
    {
        $wish = Wish::findOrFail($id);
        $wish->increment('likes');

        return response()->json([
            'success' => true,
            'likes' => $wish->likes
        ]);
    }

    public function storeMemory(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'date_label' => 'nullable|string|max:80',
            'caption' => 'required|string|max:500',
            'theme_color' => 'nullable|string|max:30',
            'sticker' => 'nullable|string|max:20',
        ]);

        $memory = Memory::create([
            'title' => $validated['title'],
            'date_label' => $validated['date_label'] ?? 'Momen Manis',
            'caption' => $validated['caption'],
            'theme_color' => $validated['theme_color'] ?? '#ffd6df',
            'sticker' => $validated['sticker'] ?? '🌸',
            'likes' => 0
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'memory' => $memory]);
        }

        return redirect()->route('memories')->with('success', 'Kenangan baru tersimpan! 📸');
    }

    public function likeMemory($id)
    {
        $memory = Memory::findOrFail($id);
        $memory->increment('likes');

        return response()->json([
            'success' => true,
            'likes' => $memory->likes
        ]);
    }

    public function updateSettings(Request $request)
    {
        $data = $request->only([
            'name',
            'nickname',
            'age',
            'theme',
            'letter_body',
            'letter_greeting',
            'letter_sender',
            'secret_wish',
        ]);

        foreach ($data as $key => $val) {
            if ($val !== null) {
                BirthdaySetting::set($key, trim($val));
            }
        }

        return response()->json(['success' => true]);
    }
}
