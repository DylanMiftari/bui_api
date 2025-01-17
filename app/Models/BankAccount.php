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
        "playerId",
        "isEnable"
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

    public function canPay(float $money, bool $bypass = false): bool {
        if(!$this->isEnable && !$bypass) {
            return 0;
        }
        return $this->costWithTransfertCost($money)  >= $this->money;
    }

    public function costWithTransfertCost(float $money): float {
        return round(($money * $this->transferCost / 100) + $money, 2);
    }

    public function storableMoney(bool $bypass = false): float {
        if(!$this->isEnable && !$bypass) {
            return 0;
        }
        return round($this->maxMoney - $this->money, 2);
    }

    public function resourcesWithQuantity() {
        if(!$this->isEnable) {
            return [];
        }
        return DB::table("bankresourceaccount")
                ->join("resource", "bankresourceaccount.resourceId", "=", "resource.id")
                ->where("bankAccountId", $this->id)
                ->select(["id", "name", "quantity"])
                ->get();
    }

    public function storableResources() {
        if(!$this->isEnable) {
            return 0;
        }
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

    public function resourceQuantity(Resource $resource): float {
        if(!$this->isEnable) {
            return 0;
        }
        $resources = $this->resourcesWithQuantity()->keyBy("name");
        return $resources->has($resource->name) ? $resources[$resource->name]->quantity : 0;
    }

    public function removeResource(Resource $resource, float $quantity) {
        $bankResourceAccount = BankResourceAccount::where("bankAccountId", $this->id)->where("resourceId", $resource->id)->first();
        $bankResourceAccount->quantity = round($bankResourceAccount->quantity - $quantity, 2);
        if($bankResourceAccount->quantity == 0) {
            $bankResourceAccount->delete();
        } else {
            $bankResourceAccount->save();
        }
    }
}
