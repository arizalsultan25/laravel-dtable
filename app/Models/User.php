<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Datatable order
    protected $orderColumns = [
        'id',
        'name',
        'email',
        'is_active'
    ];

    // datatable data function
    public function datatableData(Request $request)
    {
        // fetch data
        $search = $request->cari;
        $status = $request->status;

        $query = DB::table($this->table);

        // if has any searched keywords
        if($search){
            $query->where('name', 'like', "%$search%");

            if($status){
                $query->whereIs_active($status);
            }

            $query->orWhere('email', 'like', "%$search%");

            if($status){
                $query->whereIs_active($status);
            }
        }else{
            if($status){
                $query->whereIs_active($status);
            }
        }

        // Order column
        if ($request->order != null) {
            $orderData = json_encode($request->order);
            $data =  json_decode($orderData)[0];
            $col = $data->column;
            $direction = $data->dir;

            $column = $this->orderColumns["$col"];

            $query->orderBy($column, $direction)
                ->limit($request->length)
                ->offset($request->start);
        } else {
            $query->orderBy('id', 'desc')
                ->limit($request->length)
                ->offset($request->start);
        }

        return $query->get();
    }

    // Datatable count all results
    public function datatableCountAll(Request $request)
    {
        $count = DB::table($this->table)->count();

        return $count;
    }

    // Datatable count data filtered
    public function datatableCountFiltered(Request $request)
    {
        // fetch data
        $search = $request->cari;
        $status = $request->status;

        $query = DB::table($this->table);

        // if has any searched keywords
        if($search){
            $query->where('name', 'like', "%$search%");

            if($status){
                if($status == 'active'){
                    $statusValue = '1';
                }else{
                    $statusValue = '0';
                }

                $query->whereIs_active($statusValue);
            }

            $query->orWhere('email', 'like', "%$search%");

            if($status){
                $query->whereIs_active($statusValue);
            }
        }else{
            if($status){
                if($status == 'active'){
                    $statusValue = '1';
                }else{
                    $statusValue = '0';
                }

                $query->whereIs_active($statusValue);
            }
        }

        return $query->count();
    }
}
