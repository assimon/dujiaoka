# 推广码 API 接口文档

本文档详细描述推广码（Affiliate Code）系统提供的公开 API 接口。

## 概述

推广码 API 用于根据推广码和商品 ID 查询最优优惠码（优惠金额最大且适用于指定商品）。该接口为公开接口，无需身份认证。

**基础信息**：
- **接口地址**：`/api/affiliate/coupon`
- **请求方法**：`GET`
- **认证方式**：无需认证（公开接口）
- **返回格式**：JSON
- **字符编码**：UTF-8

---

## 接口详情

### 获取推广码对应的优惠码

根据推广码和商品 ID，返回优惠金额最大且适用的优惠码。

#### 请求信息

**HTTP Method**: `GET`

**URL**: `/api/affiliate/coupon`

#### 请求参数

| 参数名 | 类型 | 必填 | 说明 | 示例值 |
|--------|------|------|------|--------|
| aff | string | 是 | 推广码（8位字母+数字） | `aB3dE5Fg` |
| goods_id | integer | 是 | 商品ID | `3` |

**参数说明**：
- `aff`：推广码字符串，由管理后台自动生成，通常为 8 位字母和数字的组合
- `goods_id`：商品的唯一标识符，必须是大于 0 的整数

#### 成功响应

**HTTP Status**: `200 OK`

**响应示例**：
```json
{
  "success": true,
  "coupon_code": "VIP50",
  "discount": 50.00,
  "message": "已自动应用优惠金额最大的优惠码"
}
```

**字段说明**：

| 字段名 | 类型 | 说明 |
|--------|------|------|
| success | boolean | 请求是否成功，成功时为 `true` |
| coupon_code | string | 优惠码字符串 |
| discount | float | 优惠金额（单位：元） |
| message | string | 提示信息 |

#### 失败响应

##### 1. 推广码无效或不适用

**HTTP Status**: `200 OK`

**响应示例**：
```json
{
  "success": false,
  "message": "推广码无效或不适用于当前商品"
}
```

**可能原因**：
- 推广码不存在
- 推广码已被禁用
- 推广码关联的所有优惠码都不适用于指定商品
- 推广码关联的所有优惠码都已禁用

##### 2. 缺少必填参数

**HTTP Status**: `400 Bad Request`

**响应示例（缺少 aff）**：
```json
{
  "success": false,
  "message": "推广码参数 aff 不能为空"
}
```

**响应示例（缺少 goods_id）**：
```json
{
  "success": false,
  "message": "商品ID参数 goods_id 不能为空"
}
```

##### 3. 参数格式错误

**HTTP Status**: `400 Bad Request`

**响应示例（goods_id 不是整数）**：
```json
{
  "success": false,
  "message": "商品ID参数 goods_id 必须是整数"
}
```

##### 4. 服务器内部错误

**HTTP Status**: `500 Internal Server Error`

**响应示例**：
```json
{
  "success": false,
  "message": "系统错误，请稍后重试"
}
```

**说明**：当服务器内部发生异常时返回此响应，具体错误已记录在服务器日志中。

---

## 业务逻辑说明

### 优惠码选择算法

当一个推广码关联了多个优惠码时，系统按以下步骤选择最优优惠码：

1. **过滤适用优惠码**：筛选出所有满足以下条件的优惠码：
   - 优惠码状态为"启用"（`is_open = 1`）
   - 优惠码关联了指定的商品 ID

2. **按优惠金额排序**：将筛选后的优惠码按 `discount` 字段降序排序

3. **返回最优优惠码**：返回排序后的第一个优惠码（即优惠金额最大的）

**示例场景**：

推广码 `summer2024` 关联了 3 个优惠码：
- `DISCOUNT5`：优惠 5 元，适用商品 3
- `SUMMER20`：优惠 20 元，适用商品 3
- `VIP50`：优惠 50 元，适用商品 3

当请求 `?aff=summer2024&goods_id=3` 时，系统返回 `VIP50`（优惠金额最大）。

---

## 请求示例

### cURL

```bash
# 成功获取优惠码
curl -X GET "https://your-domain.com/api/affiliate/coupon?aff=aB3dE5Fg&goods_id=3"

# 推广码无效
curl -X GET "https://your-domain.com/api/affiliate/coupon?aff=invalid999&goods_id=3"

# 缺少必填参数
curl -X GET "https://your-domain.com/api/affiliate/coupon?aff=aB3dE5Fg"
```

### JavaScript Fetch API

```javascript
// 使用 Fetch API
fetch('/api/affiliate/coupon?aff=aB3dE5Fg&goods_id=3')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log('优惠码:', data.coupon_code);
      console.log('优惠金额:', data.discount);
      // 自动填充优惠码输入框
      document.getElementById('coupon_input').value = data.coupon_code;
    } else {
      console.log('获取失败:', data.message);
    }
  })
  .catch(error => {
    console.error('请求错误:', error);
  });
```

### jQuery AJAX

```javascript
// 使用 jQuery $.ajax
$.ajax({
  url: '/api/affiliate/coupon',
  type: 'GET',
  data: {
    aff: 'aB3dE5Fg',
    goods_id: 3
  },
  success: function(response) {
    if (response.success) {
      // 成功获取优惠码
      $('#coupon_input').val(response.coupon_code);
      console.log('优惠金额:', response.discount);
    } else {
      // 推广码无效
      console.log(response.message);
    }
  },
  error: function(xhr, status, error) {
    console.error('请求失败:', error);
  }
});
```

### Axios

```javascript
// 使用 Axios
axios.get('/api/affiliate/coupon', {
  params: {
    aff: 'aB3dE5Fg',
    goods_id: 3
  }
})
.then(response => {
  const data = response.data;
  if (data.success) {
    console.log('优惠码:', data.coupon_code);
    console.log('优惠金额:', data.discount);
  } else {
    console.log(data.message);
  }
})
.catch(error => {
  console.error('请求错误:', error);
});
```

---

## 集成建议

### 前端集成步骤

1. **捕获推广码**：
   ```javascript
   // 从 URL 获取推广码并存储到 localStorage
   const urlParams = new URLSearchParams(window.location.search);
   const affCode = urlParams.get('aff');
   if (affCode) {
     localStorage.setItem('affCode', affCode);
   }
   ```

2. **购买页面读取推广码**：
   ```javascript
   // 读取 localStorage 中的推广码
   const affCode = localStorage.getItem('affCode');
   if (affCode) {
     // 调用 API 获取优惠码
     // ... (见上方示例代码)
   }
   ```

3. **自动填充优惠码**：
   ```javascript
   // API 返回成功后
   if (response.success) {
     // 填充优惠码输入框
     $('#coupon_code_input').val(response.coupon_code);

     // 显示提示信息
     $('#success_tip').text('✓ 已自动应用推广优惠码').show();

     // 记录推广码到隐藏字段（用于订单统计）
     $('#affiliate_code_hidden').val(affCode);
   }
   ```

4. **允许用户修改**：
   ```javascript
   // 监听用户手动修改
   $('#coupon_code_input').on('input', function() {
     // 用户修改时隐藏提示
     $('#success_tip').hide();
   });
   ```

### 错误处理建议

1. **网络错误**：当 AJAX 请求失败时，不要阻止用户购买流程，允许用户手动输入优惠码

2. **推广码无效**：当 API 返回 `success: false` 时，保持输入框为空，不要显示错误提示（静默处理）

3. **超时处理**：设置合理的请求超时时间（建议 5 秒），超时后静默失败

示例代码：
```javascript
$.ajax({
  url: '/api/affiliate/coupon',
  type: 'GET',
  data: { aff: affCode, goods_id: goodsId },
  timeout: 5000, // 5 秒超时
  success: function(response) {
    // 处理成功
  },
  error: function() {
    // 静默失败，不影响用户体验
    console.log('[Affiliate] 获取优惠码失败');
  }
});
```

---

## 性能与限制

### 响应时间

- **目标响应时间**：< 500ms
- **数据库查询优化**：使用 Eloquent 预加载（`with(['coupons', 'coupons.goods'])`）减少 N+1 查询

### 访问频率

- **无频率限制**：该接口为公开接口，未设置访问频率限制
- **建议**：前端应避免重复调用，使用缓存机制（如 localStorage）

### 数据安全

- **无敏感信息**：接口不返回用户敏感信息
- **推广码验证**：所有推广码通过数据库查询验证，防止 SQL 注入
- **参数验证**：使用 Laravel Validator 验证所有输入参数

---

## 常见问题（FAQ）

### Q1: 为什么推广码关联了多个优惠码，但只返回一个？

**A**: 为了简化用户体验，系统自动选择优惠金额最大的优惠码。如果需要显示所有可用优惠码供用户选择，可以联系开发团队扩展此功能。

### Q2: 如果推广码关联的优惠码中有些不适用当前商品怎么办？

**A**: 系统会自动过滤掉不适用的优惠码，只从适用的优惠码中选择优惠金额最大的。如果所有优惠码都不适用，则返回 `success: false`。

### Q3: API 调用失败会影响用户购买吗？

**A**: 不会。前端应该设计为：如果 API 失败，用户仍然可以手动输入优惠码完成购买。推广码功能是增强功能，不应阻塞核心购买流程。

### Q4: 推广码的有效期是多久？

**A**: 当前版本的推广码没有有效期限制。管理员可以手动禁用推广码来停止其使用。

### Q5: 一个推广码可以使用多少次？

**A**: 当前版本没有使用次数限制。每次使用都会增加 `use_count` 统计字段，但不会限制使用。

---

## 更新日志

### Version 1.0.0 - 2026-01-11

**新增**：
- 首次发布推广码 API 接口
- 支持根据推广码和商品 ID 查询最优优惠码
- 支持多优惠码关联和智能选择
- 完整的参数验证和错误处理

---

## 技术支持

如有技术问题或建议，请通过以下方式联系：

- **Issue 反馈**：提交 GitHub Issue
- **邮箱**：support@your-domain.com

---

**文档版本**：v1.0.0
**最后更新**：2026-01-11
**维护者**：开发团队
