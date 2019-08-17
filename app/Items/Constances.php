<?php

namespace App\Items;

use Illuminate\Http\Request;

class Constances{

	// クレジットカードの手数料の係数
	const CREDIT_COEFFICIENT = 0.9;
	// オーナーのメアド
	const OWNER_EMAIL = 'Y.071081010622@icloud.com';
	// システム管理者のメアド
	const SYSTEM_ADMIN_EMAIL = 'yuichiroyamaji@hotmail.com';
	// 経費の種類
	const EXPENSE_TYPE = ['酒屋', 'おしぼり', 'NAC', '代引き', '賃料', '雑費'];
	
}