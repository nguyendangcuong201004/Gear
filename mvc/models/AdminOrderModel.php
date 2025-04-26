<?php
class AdminOrderModel extends Database
{
    public function getListOrder($search = null)
    {
        $conds = ["o.deleted = 0"];
        if ($search) {
            $s = mysqli_real_escape_string($this->con, $search);
            $conds[] = "(o.code LIKE '%{$s}%' OR o.full_name LIKE '%{$s}%' OR o.phone LIKE '%{$s}%')";
        }
        $where = "WHERE " . implode(" AND ", $conds);

        $sql = "
          SELECT
            o.id, o.code, o.full_name, o.phone, o.status,
            SUM(op.price * op.quantity * (100-op.discount)/100) AS total
          FROM orders o
          JOIN orders_products op ON op.order_id = o.id
          {$where}
          GROUP BY o.id
          ORDER BY o.created_at DESC
        ";

        $res = mysqli_query($this->con, $sql)
            or die("Query failed: " . mysqli_error($this->con));
        $orders = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $orders[] = $row;
        }
        return $orders;
    }

    public function getOrderById($id) {
        $idSafe = intval($id);
        $res = mysqli_query($this->con,
            "SELECT * FROM orders WHERE id = $idSafe AND deleted = 0"
        );
        return mysqli_fetch_assoc($res);
    }
    
    /** Lấy danh sách sản phẩm trong đơn */
    public function getOrderProducts($orderId) {
        $oid = intval($orderId);
        $res = mysqli_query($this->con,
            "SELECT 
                p.slug, p.name, op.quantity, op.price, op.discount
             FROM orders_products op
             JOIN products p ON p.id = op.product_id
             WHERE op.order_id = $oid"
        );
        $items = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $items[] = $row;
        }
        return $items;
    }


    public function softDeleteOrder(int $orderId) {
        $id = intval($orderId);
        $now = date("Y-m-d H:i:s");
        $sql = "
            UPDATE orders
            SET deleted = 1,
                deleted_at = '{$now}',
                updated_at = '{$now}'
            WHERE id = {$id}
        ";
        return mysqli_query($this->con, $sql);
    }

    public function updateStatus(int $orderId, string $status) {
        $id   = intval($orderId);
        $st   = mysqli_real_escape_string($this->con, $status);
        $now  = date("Y-m-d H:i:s");
        $sql  = "UPDATE orders
                 SET status     = '$st',
                     updated_at = '$now'
                 WHERE id = $id";
        return mysqli_query($this->con, $sql);
    }
}
