<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\choices;
use App\Models\jabatan;
use App\Models\pangkat;
use App\Models\pengaduan_masyarakat;
use App\Models\responses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    //  */
    public function index()
    {
        return view('auth.index');
    }

    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    //  */
    public function postLogin(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only(
            'nip',
            'password'
        );
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        return redirect("login")->withError('Opps! NIP atau Password anda salah');
    }

    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    //  */
    public function dashboard()
    {
        if (Auth::user()->can('admin-list')) {

            $all = pengaduan_masyarakat::count();
            $ditanggapi = pengaduan_masyarakat::where('status', 1)->count();
            $belum_ditanggapi = pengaduan_masyarakat::where('status', 0)->count();
            $pk5 = pengaduan_masyarakat::where('jenis', 'PK5')->count();
            $gepeng = pengaduan_masyarakat::where('jenis', 'Gepeng')->count();
            $pembangunan = pengaduan_masyarakat::where('jenis', 'Pembangunan')->count();
            $parkir = pengaduan_masyarakat::where('jenis', 'Parkir')->count();
            $kebisingan = pengaduan_masyarakat::where('jenis', 'Kebisingan')->count();
            // dd($ditanggapi);

            return view('dashboard.admin', [
                'all' => $all,
                'ditanggapi' => $ditanggapi,
                'belum_ditanggapi' => $belum_ditanggapi,
                'pk5' => $pk5,
                'gepeng' => $gepeng,
                'pembangunan' => $pembangunan,
                'parkir' => $parkir,
                'kebisingan' => $kebisingan,
            ]);
        } else {

            $all = pengaduan_masyarakat::where('id_pegawai', Auth::user()->id)->count();
            $ditanggapi = pengaduan_masyarakat::where('status', '1')->where('id_pegawai', Auth::user()->id)->count();
            $belum_ditanggapi = pengaduan_masyarakat::where('status', '0')->where('id_pegawai', Auth::user()->id)->count();
            // dd($ditanggapi);

            return view('dashboard.pegawai', [
                'all' => $all,
                'ditanggapi' => $ditanggapi,
                'belum_ditanggapi' => $belum_ditanggapi,
            ]);
        }

        return redirect("login")->withError('Opps! Kamu tidak memiliki Akses');

        // return view('dashboard.index');
    }

    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    //  */
    // public function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password'])
    //     ]);
    // }

    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    //  */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }

    public function profile()
    {
        $user = Auth::user();
        $jabatans = jabatan::all();
        $pangkats = pangkat::all();

        $user = User::where('nip', $user->nip)->first();

        // dd($user);
        return view('profile.index', compact('user', 'jabatans', 'pangkats'));
    }

    public function postProfile(Request $request)
    {
        $request->validate([
            'nip' => 'numeric',
            'password' => 'same:confirm-password',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ], [
            'nip.numeric' => 'NIP / NRNPNSD wajib berisikan angka',
        ]);

        $input = $request->all();


        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        if (!empty($request->file('image'))) {
            if ($image = $request->file('image')) {
                $destinationPath = 'imageUser/';
                $profileImage = $request->name . "-" . date('Ymd') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['image'] = $profileImage;
            } else {
                unset($input['image']);
            }
        } else {
            $input['image'] = Auth::user()->image;
        }

        // dd($input);

        $user = user::find(Auth::user()->id);

        $user->update($input);

        return redirect()->route('profile')
            ->with('success', 'Profile berhasil diperbarui');
    }
}
