<?php

namespace App\Repositories;

use App\Models\Channel;
use Illuminate\Support\Str;

class ChannelRepository
{
    public function create($name, $slug)
    {
        Channel::create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    }

    public function all()
    {
        return Channel::all();
    }

    public function update($id, $name, $slug)
    {
        Channel::find($id)->update([
            'name' => $name,
            'slug' => $slug,
        ]);
    }

    public function delete($id)
    {
        Channel::destroy($id);
    }
}
