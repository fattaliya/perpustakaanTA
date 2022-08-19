<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data_siswa extends Model
{
	protected $table = 'data_siswa';
    protected $fillable = ['id', 'nis', 'nama', 'id_kelas', 'jenis_kelamin', 'status', 'foto'];


    /**
     * Method One To One
     */
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    /**
     * Method One To Many
     */
    public function transaksi()
    {
    	return $this->hasMany(Transaksi::class);
    }
}
