<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    protected $fillable = ['seller_id', 'amount', 'status', 'notes'];

    public function seller() { return $this->belongsTo(Seller::class); }
}
