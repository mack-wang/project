<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $remember_token
 * @property string $avatar
 * @property bool $auth
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereAuth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Admin extends \Eloquent {}
}

namespace App{
/**
 * App\Article
 *
 * @property int $id
 * @property int $catalog_id
 * @property string $brand
 * @property string $image
 * @property string $title
 * @property string $brief 简介
 * @property string $content 65,535 个字符的字符串
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereBrand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereBrief($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereCatalogId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Catalog $catalogs
 */
	class Article extends \Eloquent {}
}

namespace App{
/**
 * App\Catalog
 *
 * @property int $id
 * @property string $catalog
 * @property bool $auth 1 重要目录，只能修改，不能删除
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereAuth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereCatalog($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool $off 1 为关闭 0 为开启
 * @property bool $top 1 为置顶 默认为时间排序
 * @property bool $recommend 0 为默认 1 为首页推荐
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Article[] $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereOff($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereRecommend($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereTop($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog withoutTrashed()
 */
	class Catalog extends \Eloquent {}
}

namespace App{
/**
 * App\City
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $level
 * @property int|null $usetype
 * @property int|null $pid
 * @property int|null $city
 * @method static \Illuminate\Database\Eloquent\Builder|\App\City whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\City whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\City wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\City whereUsetype($value)
 */
	class City extends \Eloquent {}
}

namespace App{
/**
 * App\Contact
 *
 * @property int $id
 * @property string $image
 * @property string $phone
 * @property string $time
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Contact whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Contact extends \Eloquent {}
}

namespace App{
/**
 * App\Headline
 *
 * @property-read \App\Article $articles
 * @mixin \Eloquent
 * @property int $id
 * @property string $headline
 * @property int $view 浏览数
 * @property int $article_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Headline whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Headline whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Headline whereHeadline($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Headline whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Headline whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Headline whereView($value)
 */
	class Headline extends \Eloquent {}
}

namespace App{
/**
 * App\SlideImage
 *
 * @property int $id
 * @property int $article_id
 * @property string $redirect_path
 * @property string $image_path
 * @property bool $state 0 为下架 1为上架
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Article $articles
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereRedirectPath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SlideImage extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\UserCompany $user_companies
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\UserAddress
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $real_name
 * @property string|null $mail_phone
 * @property string|null $province
 * @property string|null $city
 * @property string|null $area
 * @property string|null $address
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAddress whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAddress whereMailPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAddress whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAddress whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAddress whereUserId($value)
 */
	class UserAddress extends \Eloquent {}
}

namespace App{
/**
 * App\UserCompany
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $company
 * @property string|null $size 1-20 20-50 50-100 100人以上
 * @property string|null $industry
 * @property string|null $phone
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCompany whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCompany whereIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCompany wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCompany whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCompany whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCompany whereUserId($value)
 */
	class UserCompany extends \Eloquent {}
}

