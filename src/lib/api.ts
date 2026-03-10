const API_BASE = "https://nu.apipainel.com.br/api";

export async function apiPost<T = unknown>(endpoint: string, body: Record<string, unknown>): Promise<T> {
  const res = await fetch(`${API_BASE}/${endpoint}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(body),
  });

  const data = await res.json();

  if (!res.ok) {
    throw new Error(data?.error || "Erro na requisição");
  }

  return data as T;
}

export async function apiGet<T = unknown>(endpoint: string, params?: Record<string, string>): Promise<T> {
  const url = new URL(`${API_BASE}/${endpoint}`);
  if (params) {
    Object.entries(params).forEach(([k, v]) => url.searchParams.set(k, v));
  }

  const res = await fetch(url.toString());
  const data = await res.json();

  if (!res.ok) {
    throw new Error(data?.error || "Erro na requisição");
  }

  return data as T;
}
