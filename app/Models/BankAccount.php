<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = "bankaccount";

    protected $fillable = [
        "accountMaintenanceCost",
        "transferCost",
        "maxMoney",
        "maxResource",
        "bankId",
        "playerId"
    ];

    public function player(): HasOne {
        return $this->hasOne(User::class, "id", "playerId");
    }

    public function bankResourceAccount(): HasMany {
        return $this->hasMany(BankResourceAccount::class, "bankAccountId", "id");
    }

    public function transactions(): HasMany {
        return $this->hasMany(BankAccountTransaction::class, "bankAccountId", "id");
    }

    public function bank(): HasOne {
        return $this->hasOne(Bank::class, "id", "bankId");
    }

    public function storableMoney(): float {
        return round($this->maxMoney - $this->money, 2);
    }

    public function resourcesWithQuantity() {
        return DB::table("bankresourceaccount")
                ->join("resource", "bankresourceaccount.resourceId", "=", "resource.id")
                ->where("bankAccountId", $this->id)
                ->select(["id", "name", "quantity"])
                ->get();
    }

    public function storableResources() {
        return round($this->maxResource - $this->resourcesWithQuantity()->sum("quantity"), 2);
    }

    public function addResource(int $resourceId, float $quantity): void {
        $bankResourceAccount = BankResourceAccount::where("bankAccountId", $this->id)->where("resourceId", $resourceId)->first();
        if($bankResourceAccount === null) {
            BankResourceAccount::create([
                "bankAccountId" => $this->id,
                "resourceId" => $resourceId,
                "quantity" => $quantity
            ]);
        } else {
            $bankResourceAccount->quantity += $quantity;
            $bankResourceAccount->save();
        }
    }
}
