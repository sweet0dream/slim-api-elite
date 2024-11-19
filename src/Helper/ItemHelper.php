<?php

namespace App\Helper;

use Sweet0dream\IntimAnketaContract;

class ItemHelper
{
    private IntimAnketaContract $contract;

    public function getAllIds(array $items): array
    {
        return array_map(fn($item) => $item['id'], $items);
    }

    public function prepareItem(array $item, array $city): array
    {
        $this->contract = new IntimAnketaContract($item['type']);

        return [
            'id' => $item['id'],
            'relation' => [
                'city_id' => $item['city_id'],
                'user_id' => $item['user_id'],
            ],
            'type' => [
                'key' => $item['type'],
                'value' => $this->contract->getSingularMeta()[$item['type']],
            ],
            'phone' => $item['status_active']
                ? preg_replace(
                    '/^(\d{3})(\d{3})(\d{2})(\d{2})$/iu',
                    '+7($1)$2-$3-$4',
                    $item['phone']
                ) : null,
            'info' => $this->getInfoItem(json_decode($item['info'], true)),
            'service' => $this->getServiceItem(json_decode($item['service'], true)),
            'price' => $this->getPriceItem(json_decode($item['price'], true)),
            'dopinfo' => $item['dopinfo'],
            'photo' => $item['photo'],
            'rao' => $city['rao'][$item['rao']],
            'meta' => [
                $this->contract->getSingularMeta()[$item['type']],
                $this->contract->getPluralMeta()[$item['type']],
                $this->contract->getPluralMeta()[$item['type']] . ' ' . $city['name'][1]
            ],
            'date' => $this->getDateItem([
                $item['date_add'],
                $item['date_edit'],
                $item['date_top']
            ]),
            'status' => $this->getStatusItem([
                $item['status_active'],
                $item['status_premium'],
                $item['status_vip'],
                $item['status_real'],
            ]),
            'view' => $this->getViewItem([
                $item['view_day'],
                $item['view_month'],
            ])
        ];
    }

    public function prepareItemReviews(array $reviews): array
    {
        return count($reviews) > 0
            ? [
                'count' => count($reviews),
                'value' => array_map(fn($review) => $this->getReview($review), $reviews)
            ] : [];
    }

    private function getReview(array $review): array
    {
        return [
            'id' => $review['id'],
            'rating' => $review['rating'],
            'verify' => $review['verify'],
            'date' => $review['created_at'],
            'text' => str_contains($review['review'], '||')
                ? [
                    'client' => explode('||', $review['review'])[0],
                    'answer' => explode('||', $review['review'])[1],
                ] : [
                    'client' => $review['review']
                ]
        ];
    }

    private function getInfoItem(array $item): array
    {
        foreach ($item as $k => $v) {
            $info[$k] = [
                'name' => $this->contract->getField()['info'][$k]['name'],
                'value' => $this->contract->getField()['info'][$k]['value'][$v] ?? $v
            ];
        }

        return $info ?? [];
    }

    private function getServiceItem(array $item): array
    {
        foreach($this->contract->getField()['service'] as $k => $v) {
            $service[$k]['name'] = $v['name'];
            foreach($v['value'] as $kv => $vv) {
                $service[$k]['value'][$kv] = [
                    'name' => $vv,
                    'turn' => (int)(isset($item[$k]) && in_array($kv, $item[$k]))
                ];
            }
        }

        return $service ?? [];
    }

    private function getPriceItem(array $item): array
    {
        foreach ($item as $k => $v) {
            if ((int)$v > 0) {
                $price[$k] = [
                    'name' => $this->contract->getField()['price'][$k]['name'],
                    'value' => (int)$v
                ];
            }
        }

        return $price ?? [];
    }

    private function getDateItem(array $item): array
    {
        return array_combine(['add', 'edit', 'top'], $item);
    }

    private function getStatusItem(array $item): array
    {
        return array_combine(['active', 'premium', 'vip', 'real'], $item);
    }

    private function getViewItem(array $item): array
    {
        return array_combine(['day', 'month'], $item);
    }
}