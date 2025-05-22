<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'message',
        'image',
        'status',
        'email',
        'phone',
        'company',
        'submission_token',
        'is_featured',
        'sort_order',
    ];

    /**
     * Generate a new submission token.
     *
     * @return string
     */
    public static function generateSubmissionToken()
    {
        return Str::random(32);
    }

    /**
     * Scope a query to only include approved testimonials.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending testimonials.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include featured testimonials.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to order testimonials by sort order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id', 'desc');
    }

    /**
     * Approve the testimonial.
     *
     * @return bool
     */
    public function approve()
    {
        return $this->update(['status' => 'approved']);
    }

    /**
     * Reject the testimonial.
     *
     * @return bool
     */
    public function reject()
    {
        return $this->update(['status' => 'rejected']);
    }
}