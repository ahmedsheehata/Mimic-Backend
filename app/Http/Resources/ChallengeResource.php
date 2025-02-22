<?php

namespace App\Http\Resources;

use App\Traits\EncryptDecryptTrait;
use App\Models\Client;
use App\Models\Hashtag;
use App\Models\Favourite;

use Illuminate\Http\Resources\Json\JsonResource;

class ChallengeResource extends JsonResource
{
    use EncryptDecryptTrait;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return
            [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'end_date' => $this->end_date,
                'creator' => $this->creater_id != null ? new ClientResource($this->client) : null,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'share_count' => $this->shar_count,
                'is_owner_of_challenge' => ((!empty(auth('client')->user()->id)) && ($this->clinet_id == auth('client')->user()->id)) ? true : false,
                'video' => VideoResource::collection($this->videos) ?? null,
                'is_owner_of_video' => !empty(auth('client')->user()->id) ? (!empty($this->videos()->where('client_id', auth('client')->user()->id)->first()) ? true : false) : false,
                'members' => count($this->who_join) > 0 ? ClientCustomResource::collection(Client::whereIn('id', $this->who_join)->get()) : null,
                'comment_count' => $this->comment_count,
                'like_count' => $this->like_count,
                'watch_count' => $this->watch_count,
                'is_favorite' => (!empty(auth('client')->user()->id)) && !empty(Favourite::where('challenge_id', $this->id)->where('client_id', auth('client')->user()->id)->first()) ? true : false,
            ];
    }
}
