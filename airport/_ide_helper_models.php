<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Activity
 *
 * @property int $id
 * @property string $type apply 是测评活动 kill 是秒杀活动 airport 是机场活动 shop 是终端活动 wed婚庆活动 5 其他活动1 6 其他活动2
 * @property int $pid 对应申领或秒杀的烟的id
 * @property bool $off 若为1，则强制关闭活动，活动不删除，可以看，但用户无法报名参加
 * @property string $start_at
 * @property string $end_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ActivityAttr $activity_attrs
 * @property-read \App\Models\ActivityPrize $activity_prizes
 * @property-read \App\Models\ActivityRequire $activity_requires
 * @property-read \App\Models\Article $articles
 * @property-read \App\Models\FetchCigarette $fetch_cigarettes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GrassEveryday[] $grass_everydays
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereEndAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereOff($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity wherePid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $cigarette_id 对应申领或秒杀的烟的id
 * @property-read \App\Models\ActivityShop $activity_shops
 * @property-read \App\Models\ActivityTask $activity_tasks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PrizeDescribe[] $prize_describes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResultApply[] $result_applies
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResultTask[] $result_tasks
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereCigaretteId($value)
 * @property int $article_id 对应的文章
 * @property bool $elect 0 系统定时智能选出 1 人工选出 2 选择完毕
 * @property-read \App\Models\ActivityHeadimg $activity_headimgs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActivityQuestion[] $activity_questions
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereElect($value)
 */
	class Activity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivityAttr
 *
 * @property int $id
 * @property int $activity_id
 * @property string $title
 * @property string $image_path 申领和秒杀活动的封面图
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityAttr whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityAttr whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityAttr whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityAttr whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityAttr whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityAttr whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\ActivityPrize $activity_prizes
 */
	class ActivityAttr extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivityHeadimg
 *
 * @property int $id
 * @property int $activity_id
 * @property string $image_path 用逗号分开的路径
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ActivityAttr $activity_attrs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityHeadimg whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityHeadimg whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityHeadimg whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityHeadimg whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityHeadimg whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ActivityHeadimg extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivityPrize
 *
 * @property int $id
 * @property int $activity_id
 * @property int $cigarette_id
 * @property string $name
 * @property int $count 奖品数量
 * @property int $price 奖品价格
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereCigaretteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\ActivityRequire $activity_requires
 * @property string $description 奖品描述用逗号分开每一条
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereDescription($value)
 */
	class ActivityPrize extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivityQuestion
 *
 * @property int $activity_id
 * @property int $question_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Question $questions
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityQuestion whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityQuestion whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityQuestion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ActivityQuestion extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivityRequire
 *
 * @property int $id
 * @property int $activity_id
 * @property int $level 等级要求
 * @property int $exp 经验要求
 * @property int $request 其他自定义要求
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereExp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereRequest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Article $articles
 * @property-read \App\Models\ActivityShop $activity_shops
 * @property-read \App\Models\ActivityTask $activity_tasks
 */
	class ActivityRequire extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivityShop
 *
 * @property int $id
 * @property int $activity_id
 * @property string $image_path
 * @property string $button 按钮文字
 * @property string $message 店铺名字后的备注，留言，说明
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Activity $activities
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereButton($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $link 独有活动链接例如 /wechat/link/takephoto
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereLink($value)
 * @property-read \App\Models\Article $articles
 * @property string|null $avatar_path
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityShop whereAvatarPath($value)
 */
	class ActivityShop extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivityTask
 *
 * @property int $id
 * @property int $activity_id
 * @property string $type 任务类型 airport 机场任务 shop 烟店任务 all 通用任务
 * @property string $link 任务链接例如 /wechat/task/takephoto
 * @property string $message 任务简称
 * @property string $title 任务全称
 * @property string $prize_name 滴水 颗种子 张礼品券
 * @property string $prize_type water 水 seed 种子 ticket 礼品券
 * @property int $prize_count 奖励奖品的数量
 * @property bool $top 置顶，为1是置顶
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask wherePrizeCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask wherePrizeName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask wherePrizeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereTop($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ActivityTask extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $remember_token
 * @property string $headimgurl
 * @property bool $auth
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereAuth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereHeadimgurl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Article
 *
 * @property int $id
 * @property int $activity_id
 * @property string $content 65,535 个字符的字符串
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\ActivityShop $activity_shops
 * @property-read \App\Models\ActivityTask $activity_tasks
 * @property string $title 文章标题
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activities
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereTitle($value)
 */
	class Article extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AuthArea
 *
 * @property int $id
 * @property int $activity_id
 * @property int $area_id 凡出现的area_id都不能参加参加对应id活动
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthArea whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthArea whereAreaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthArea whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthArea whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AuthArea extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AuthShop
 *
 * @property int $id
 * @property int $activity_id
 * @property int $shop_id 凡出现的shop_id都不能参加对应id的活动
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthShop whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthShop whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthShop whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthShop whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthShop whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AuthShop extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cigarette
 *
 * @property int $id
 * @property string $cigarette
 * @property string $type
 * @property string $size
 * @property string $tar
 * @property string $nicotine
 * @property string $carbon
 * @property string $packet_code
 * @property string $carton_code
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereCarbon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereCartonCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereCigarette($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereNicotine($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette wherePacketCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereTar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereType($value)
 * @mixin \Eloquent
 */
	class Cigarette extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CigaretteLabel
 *
 * @property int $id
 * @property int $user_id
 * @property int $cigarette_id
 * @property bool $label_id 0 为常抽的品牌 1为期望的品牌
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigaretteLabel whereCigaretteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigaretteLabel whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigaretteLabel whereLabelId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigaretteLabel whereUserId($value)
 * @mixin \Eloquent
 */
	class CigaretteLabel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CigarettePrice
 *
 * @property int $cigarette_id
 * @property int $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigarettePrice whereCigaretteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigarettePrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigarettePrice wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigarettePrice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class CigarettePrice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property bool $level
 * @property bool $usetype
 * @property int $pid
 * @property int $city
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City wherePid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereUsetype($value)
 * @mixin \Eloquent
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FetchCigarette
 *
 * @property int $id
 * @property int $pid
 * @property string $image_url
 * @property string $name
 * @property int $brand_id
 * @property string $brand
 * @property string $packet_code
 * @property string $carton_code
 * @property string $type
 * @property string $size
 * @property int $price
 * @property string $company
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereBrand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereBrandId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereCartonCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereCompany($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereImageUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette wherePacketCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette wherePid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereType($value)
 * @mixin \Eloquent
 * @property int $cigarette_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereCigaretteId($value)
 * @property int|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FetchCigarette whereStatus($value)
 */
	class FetchCigarette extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FetchCigaretteImage
 *
 * @property int $pid
 * @property string $image_path
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigaretteImage whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigaretteImage wherePid($value)
 * @mixin \Eloquent
 * @property int $cigarette_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigaretteImage whereCigaretteId($value)
 */
	class FetchCigaretteImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Grass
 *
 * @property int $id
 * @property int $user_id
 * @property int $water 当前这棵草的水滴
 * @property int $total 当前这棵草长成所有要的经验值
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grass whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grass whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grass whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grass whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grass whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grass whereWater($value)
 * @mixin \Eloquent
 * @property-read \App\Models\GrassAttr $grass_attrs
 */
	class Grass extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GrassAttr
 *
 * @property int $user_id
 * @property int $water 水量，单位量100滴
 * @property int $seed 种子，1个种子种一棵草
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GrassAttr whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GrassAttr whereSeed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GrassAttr whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GrassAttr whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GrassAttr whereWater($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Grass[] $grasses
 */
	class GrassAttr extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GrassEveryday
 *
 * @mixin \Eloquent
 */
	class GrassEveryday extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Lottery
 *
 * @property int $id
 * @property int|null $prize_id
 * @property int|null $start_num 起点数
 * @property int|null $end_num 终点数
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereEndNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery wherePrizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereStartNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Lottery extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LotteryResult
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $prize_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryResult wherePrizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryResult whereUserId($value)
 * @mixin \Eloquent
 */
	class LotteryResult extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostPrize
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $prize_id
 * @property int|null $status 1为已经邮寄，0为未邮寄
 * @property string|null $tracking_number 快递单号
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize wherePrizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize whereTrackingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\QrcodePrize $qrcode_prizes
 * @property-read \App\Models\UserAddress $user_addresses
 * @property-read \App\Models\UserAttr $user_attrs
 * @property-read \App\Models\UserInfo $user_infos
 * @property-read \App\Models\UserWechat $user_wechats
 * @property-read \App\Models\User $users
 */
	class PostPrize extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PrizeDescribe
 *
 * @mixin \Eloquent
 */
	class PrizeDescribe extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QrcodePath
 *
 * @property int $qrcode_id
 * @property string|null $qrcode_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $hashids
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePath whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePath whereHashids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePath whereQrcodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePath whereQrcodePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePath whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class QrcodePath extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QrcodePrize
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $count
 * @property int|null $send_out
 * @property int|null $cost 消耗的礼品券数量
 * @property int|null $type 0 是专门供应兑奖券换的二维码奖品 1 是专门供应抽奖用的奖品
 * @property int|null $expire 二维码有效期 单位秒
 * @property int|null $off 0 开启 1 闭关
 * @property string|null $image_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereSendOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class QrcodePrize extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Qrcodes
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $shop_id 用户绑定的店铺
 * @property int|null $prize_id 奖品的id
 * @property int|null $state 0 未兑奖 1 已经兑奖
 * @property string|null $start_at 二维码开启时间
 * @property string|null $end_at 二维码失效时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\QrcodePath $qrcode_paths
 * @property-read \App\Models\QrcodePrize $qrcode_prizes
 * @property-read \App\Models\Shop $shops
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes wherePrizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereUserId($value)
 * @mixin \Eloquent
 */
	class Qrcodes extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $image_path
 * @property string $question
 * @property string $options 单选和多选的选项，用英文逗号分开选项
 * @property string $selected 单选和多选的答案，用1234来表示 1表示第一个选项，34表示3和4选项
 * @property string $type radio 单选 select 多选 photo 照片 input 输入
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActivityQuestion[] $activity_questions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResultQuestion[] $result_questions
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereOptions($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereQuestion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereSelected($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question withoutTrashed()
 */
	class Question extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Report
 *
 * @property int $id
 * @property int $activity_id 用户获奖的活动id
 * @property bool $scores 打分，满分5分
 * @property int $user_id
 * @property string $smoke 用户的品吸感受
 * @property string $images 上传图片的地址，最多9张
 * @property int $goods 用户点赞总数
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReportGood[] $report_goods
 * @property-read \App\Models\UserWechat $user_wechats
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereGoods($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereImages($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereScores($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereSmoke($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereUserId($value)
 * @mixin \Eloquent
 */
	class Report extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReportGood
 *
 * @property int $id
 * @property int $report_id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Report $reports
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ReportGood whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ReportGood whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ReportGood whereReportId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ReportGood whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ReportGood whereUserId($value)
 * @mixin \Eloquent
 */
	class ReportGood extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResultApply
 *
 * @property int $id
 * @property int $activity_id
 * @property int $user_id
 * @property bool $status 任何活动都是四个状态 null 已参与 0 是失败 1 是成功
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultApply whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultApply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultApply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultApply whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultApply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultApply whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Activity $activities
 * @property-read \App\Models\ActivityAttr $activity_attrs
 * @property-read \App\Models\Report $reports
 * @property-read \App\Models\UserWechat $user_wechats
 * @property-read \App\Models\UserInfo $user_infos
 */
	class ResultApply extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResultQuestion
 *
 * @property int $id
 * @property int $activity_id 不同的活动，可以引用相同的问题
 * @property int $question_id
 * @property int $user_id
 * @property string $selected 用户的回答
 * @property string $input
 * @property string $image_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereInput($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereSelected($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereUserId($value)
 * @mixin \Eloquent
 */
	class ResultQuestion extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResultTask
 *
 * @property int $id
 * @property int $activity_id
 * @property int $user_id
 * @property bool $status 任何活动都是四个状态 null 已参与 0 是失败 1 是成功
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Activity $activities
 * @property-read \App\Models\ActivityTask $activity_tasks
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultTask whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultTask whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultTask whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultTask whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultTask whereUserId($value)
 * @mixin \Eloquent
 */
	class ResultTask extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ScanResult
 *
 * @property int $qrcode_id
 * @property int|null $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanResult whereQrcodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanResult whereUserId($value)
 * @mixin \Eloquent
 */
	class ScanResult extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Shop
 *
 * @property int $id
 * @property string $name
 * @property string $phone 店铺的老板
 * @property string $cigarette_id
 * @property int $area_id
 * @property string $type apply 是测评活动 kill 是秒杀活动 airport 是机场活动 shop 是终端活动 wed婚庆活动 5 其他活动1 6 其他活动2
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ShopAddress $shop_addresses
 * @property-read \App\Models\ShopArea $shop_areas
 * @property-read \App\Models\ShopAttr $shop_attrs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShopManager[] $shop_managers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereAreaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereCigaretteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Shop extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopAddress
 *
 * @property int $id
 * @property int $shop_id
 * @property int $manager_id
 * @property string $mail_phone
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereArea($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereMailPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereManagerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ShopAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopArea
 *
 * @property int $id
 * @property string $area
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop[] $shops
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopArea whereArea($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopArea whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopArea whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ShopArea extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopAttr
 *
 * @property int $id
 * @property int $shop_id
 * @property string $type 店铺类别A B C
 * @property string $level 店铺等级 自定义
 * @property int $scores 店铺分数
 * @property bool $black 1 为黑名单
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Shop $shops
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereBlack($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereScores($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ShopAttr extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopHeadimg
 *
 * @property int $shop_id
 * @property string $image_path 店铺头像
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopHeadimg whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopHeadimg whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopHeadimg whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopHeadimg whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ShopHeadimg extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopManager
 *
 * @property int $id
 * @property int $shop_id
 * @property int $user_id
 * @property string $manager_name
 * @property string $phone
 * @property string $remember_token
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ShopAddress $shop_addresses
 * @property-read \App\Models\ShopAttr $shop_attrs
 * @property-read \App\Models\Shop $shops
 * @property-read \App\Models\UserInfo $user_infos
 * @property-read \App\Models\UserWechat $user_wechats
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereManagerName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereUserId($value)
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager withoutTrashed()
 */
	class ShopManager extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SlideImage
 *
 * @property int $id
 * @property string $redirect_path
 * @property string $image_path
 * @property bool $state 0 为下架 1为上架
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereRedirectPath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $article_id
 * @property-read \App\Models\Article $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereArticleId($value)
 */
	class SlideImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property int $shop_id
 * @property string $openid
 * @property bool $register
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\GrassAttr $grass_attrs
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Models\ShopManager $shop_managers
 * @property-read \App\Models\Shop $shops
 * @property-read \App\Models\UserAddress $user_addresses
 * @property-read \App\Models\UserAttr $user_attrs
 * @property-read \App\Models\UserCigarette $user_cigarettes
 * @property-read \App\Models\UserInfo $user_infos
 * @property-read \App\Models\UserWechatInfo $user_wechat_infos
 * @property-read \App\Models\UserWechat $user_wechats
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRegister($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $password
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserAddress
 *
 * @property int $id
 * @property int $user_id
 * @property string $mail_phone
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\UserAttr $user_attrs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereArea($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereMailPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\GrassAttr $grass_attrs
 */
	class UserAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserAttr
 *
 * @property int $id
 * @property int $user_id
 * @property string $real_name
 * @property string $email
 * @property string $id_card
 * @property bool $age
 * @property string $job
 * @property int $income 平均每月收入
 * @property string $education
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereAge($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereEducation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereIdCard($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereIncome($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereJob($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereRealName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\UserAddress $user_addresses
 */
	class UserAttr extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserCigarette
 *
 * @property int $id
 * @property int $user_id
 * @property bool $age
 * @property string $brand 当前在抽的品牌
 * @property string $expect 期望获得的香烟品牌
 * @property int $price 平均所抽香烟价位
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereAge($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereBrand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereExpect($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\UserAttr $user_attrs
 */
	class UserCigarette extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserInfo
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $exp
 * @property bool $level
 * @property int $ticket
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\UserAddress $user_addresses
 * @property-read \App\Models\UserAttr $user_attrs
 * @property-read \App\Models\UserCigarette $user_cigarettes
 * @property-read \App\Models\User $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereExp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereTicket($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereUserId($value)
 * @mixin \Eloquent
 */
	class UserInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserLevelName
 *
 * @property int $id
 * @property string $name level和id对应的等级名字
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserLevelName whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserLevelName whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserLevelName whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserLevelName whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class UserLevelName extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserMessageCode
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserMessageCode whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserMessageCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserMessageCode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserMessageCode wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserMessageCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserMessageCode whereUserId($value)
 * @mixin \Eloquent
 */
	class UserMessageCode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserRecommend
 *
 * @property int $id
 * @property int|null $user_id 当前用户的user_id
 * @property int|null $recommend_id 推荐人的user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\UserInfo $user_infos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRecommend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRecommend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRecommend whereRecommendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRecommend whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRecommend whereUserId($value)
 * @mixin \Eloquent
 */
	class UserRecommend extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserWechat
 *
 * @property int $id
 * @property int $user_id
 * @property string $nickname
 * @property string $headimgurl
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\UserWechatInfo $user_wechat_infos
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechat whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechat whereHeadimgurl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechat whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechat whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechat whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\UserInfo $user_infos
 */
	class UserWechat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserWechatInfo
 *
 * @property int $id
 * @property int $user_id
 * @property string $province
 * @property string $city
 * @property bool $sex
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\UserWechat $user_wechat_infos
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereUserId($value)
 * @mixin \Eloquent
 */
	class UserWechatInfo extends \Eloquent {}
}

