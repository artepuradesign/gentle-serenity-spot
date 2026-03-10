import { useNavigate } from "react-router-dom";
import { useState, useEffect, useRef } from "react";
import { ChevronLeft, ChevronRight, HelpCircle, MoreHorizontal, Plus, Send, BarChart3, TrendingUp, Wallet, DollarSign, ArrowUpRight, Search, BarChart2, X, FileText, Settings, Key } from "lucide-react";
import { apiGet } from "@/lib/api";

interface ContaData {
  conta_id: number;
  saldo: number;
  limite_credito: number;
}

interface Transacao {
  id: number;
  tipo: string;
  categoria: string;
  descricao: string;
  valor: string;
  data_transacao: string;
  beneficiario_nome: string | null;
}

interface ContaResponse {
  conta: ContaData;
  fatura_atual: number;
  transacoes: Transacao[];
}

const MESES = [
  "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
  "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
];

const Saldo = () => {
  const navigate = useNavigate();
  const [contaData, setContaData] = useState<ContaData | null>(null);
  const [faturaAtual, setFaturaAtual] = useState(0);
  const [transacoes, setTransacoes] = useState<Transacao[]>([]);
  const [searchTerm, setSearchTerm] = useState("");
  const [loading, setLoading] = useState(true);
  const [showMenu, setShowMenu] = useState(false);
  const [showMonthPicker, setShowMonthPicker] = useState(false);
  const [selectedMonth, setSelectedMonth] = useState<string | null>(null);
  const [userId, setUserId] = useState<number | null>(null);
  const [contaId, setContaId] = useState<number | null>(null);

  useEffect(() => {
    const saved = localStorage.getItem("nu_user") || sessionStorage.getItem("nu_user");
    if (!saved) {
      navigate("/login");
      return;
    }
    const user = JSON.parse(saved);
    setUserId(user.id);
    fetchData(user.id);
  }, [navigate]);

  const fetchData = async (uid: number) => {
    try {
      setLoading(true);
      const data = await apiGet<ContaResponse>("conta.php", { usuario_id: String(uid) });
      setContaData(data.conta);
      setContaId(data.conta.conta_id);
      setFaturaAtual(data.fatura_atual);
      setTransacoes(data.transacoes || []);
    } catch (err) {
      console.error("Erro ao carregar dados:", err);
    } finally {
      setLoading(false);
    }
  };

  const formatCurrency = (value: number) =>
    value.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });

  const saldo = contaData?.saldo ?? 0;

  const quickActions = [
    { icon: Plus, label: "Trazer\ndinheiro" },
    { icon: Send, label: "Transferir" },
    { icon: BarChart3, label: "Pagar" },
    { icon: TrendingUp, label: "Investir e\nGuardar" },
  ];

  // Generate months list (current month back ~12 months)
  const now = new Date();
  const currentDay = now.getDate();
  const monthsList: { label: string; value: string; year: number }[] = [];
  for (let i = 0; i < 12; i++) {
    const d = new Date(now.getFullYear(), now.getMonth() - i, 1);
    const year = d.getFullYear();
    const month = d.getMonth();
    let label = MESES[month];
    // For current month, show partial range
    if (i === 0) {
      label = `${MESES[month]} (de 01 ao ${String(currentDay).padStart(2, "0")})`;
    }
    monthsList.push({ label, value: `${year}-${String(month + 1).padStart(2, "0")}`, year });
  }

  // Group by year
  const byYear: Record<number, typeof monthsList> = {};
  monthsList.forEach(m => {
    if (!byYear[m.year]) byYear[m.year] = [];
    byYear[m.year].push(m);
  });

  const handleExportExtrato = () => {
    if (!selectedMonth || !contaId) return;

    let startDate: string;
    let endDate: string;

    if (selectedMonth.startsWith("period-")) {
      const months = parseInt(selectedMonth.replace("period-", ""));
      const end = new Date();
      const start = new Date(end.getFullYear(), end.getMonth() - months, end.getDate());
      startDate = start.toISOString().split("T")[0];
      endDate = end.toISOString().split("T")[0];
    } else {
      const [year, month] = selectedMonth.split("-");
      startDate = `${year}-${month}-01`;
      const lastDay = new Date(parseInt(year), parseInt(month), 0).getDate();
      endDate = `${year}-${month}-${String(lastDay).padStart(2, "0")}`;
    }

    navigate(`/extrato-export?conta_id=${contaId}&data_inicio=${startDate}&data_fim=${endDate}`);
  };

  return (
    <div className="min-h-screen bg-background font-body max-w-md mx-auto relative">
      {/* Top bar */}
      <div className="flex items-center justify-between px-5 pt-12 pb-4">
        <button onClick={() => navigate("/painel")} className="p-1">
          <ChevronLeft className="h-6 w-6 text-foreground" />
        </button>
        <div className="flex items-center gap-5">
          <button className="p-1">
            <HelpCircle className="h-6 w-6 text-muted-foreground" />
          </button>
          <button className="p-1" onClick={() => setShowMenu(true)}>
            <MoreHorizontal className="h-6 w-6 text-muted-foreground" />
          </button>
        </div>
      </div>

      {/* Saldo disponível */}
      <section className="px-5 pt-4 pb-6">
        <p className="text-base text-muted-foreground font-body mb-1">Saldo disponível</p>
        <p className="text-[32px] font-bold text-foreground font-heading leading-tight">
          {loading ? "Carregando..." : formatCurrency(saldo)}
        </p>
      </section>

      {/* Saldo Separado */}
      <button className="w-full px-5 py-4 flex items-center gap-4 active:bg-muted/50 transition-colors">
        <div className="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center">
          <Wallet className="h-5 w-5 text-foreground" />
        </div>
        <div className="flex-1 text-left">
          <p className="text-sm text-muted-foreground font-body">Saldo Separado</p>
          <p className="text-base font-semibold text-foreground font-heading">
            {loading ? "..." : formatCurrency(0)}
          </p>
        </div>
        <ChevronRight className="h-5 w-5 text-muted-foreground" />
      </button>

      {/* Gastos Previstos */}
      <button className="w-full px-5 py-4 flex items-center gap-4 active:bg-muted/50 transition-colors">
        <div className="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center">
          <DollarSign className="h-5 w-5 text-foreground" />
        </div>
        <div className="flex-1 text-left">
          <p className="text-sm text-muted-foreground font-body">Gastos Previstos</p>
          <p className="text-base font-semibold text-foreground font-heading">
            {loading ? "..." : formatCurrency(faturaAtual)}
          </p>
          <p className="text-xs text-muted-foreground font-body">Programar com Seu Assistente</p>
        </div>
        <ChevronRight className="h-5 w-5 text-muted-foreground" />
      </button>

      {/* Total em investimentos */}
      <button className="w-full px-5 py-4 flex items-center gap-4 active:bg-muted/50 transition-colors">
        <div className="w-10 h-10 flex items-center justify-center">
          <span className="text-2xl font-bold text-foreground font-heading">$</span>
        </div>
        <div className="flex-1 text-left">
          <p className="text-sm text-muted-foreground font-body">Total em investimentos</p>
          <p className="text-base font-semibold text-foreground font-heading">
            {loading ? "..." : formatCurrency(1.60)}
          </p>
          <div className="flex items-center gap-1">
            <ArrowUpRight className="h-3.5 w-3.5 text-nu-green" />
            <span className="text-xs text-nu-green font-body">{formatCurrency(3.15)}</span>
          </div>
        </div>
        <ChevronRight className="h-5 w-5 text-muted-foreground" />
      </button>

      {/* Quick Actions */}
      <section className="px-5 py-6">
        <div className="flex justify-between gap-3">
          {quickActions.map((action, i) => (
            <button key={i} className="flex flex-col items-center gap-2 flex-1">
              <div className="w-16 h-16 rounded-full bg-nu-purple-light flex items-center justify-center">
                <action.icon className="h-6 w-6 text-primary" />
              </div>
              <span className="text-xs text-foreground text-center leading-tight whitespace-pre-line font-body">
                {action.label}
              </span>
            </button>
          ))}
        </div>
      </section>

      {/* Banner FGTS */}
      <section className="px-5 pb-6">
        <div className="bg-nu-purple-light rounded-2xl p-5 flex items-center gap-4">
          <p className="flex-1 text-sm text-foreground font-body leading-snug">
            Antecipe as parcelas do seu saque-aniversário FGTS.
          </p>
          <div className="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
            <DollarSign className="h-6 w-6 text-primary" />
          </div>
        </div>
        <div className="flex justify-center mt-3">
          <div className="w-2 h-2 rounded-full bg-foreground" />
        </div>
      </section>

      {/* Resumo financeiro */}
      <section className="px-5 pb-6">
        <button className="w-full flex items-center justify-between py-2">
          <div>
            <h2 className="text-xl font-bold text-foreground font-heading mb-1 text-left">Resumo financeiro</h2>
            <p className="text-sm text-muted-foreground font-body text-left">
              Confira a análise dos seus gastos de março
            </p>
          </div>
          <div className="flex items-center gap-2">
            <span className="bg-primary text-primary-foreground text-xs font-bold px-2 py-0.5 rounded">Novo</span>
            <ChevronRight className="h-5 w-5 text-muted-foreground" />
          </div>
        </button>
      </section>

      {/* Histórico */}
      <section className="px-5 pb-4">
        <div className="flex items-center justify-between mb-4">
          <h2 className="text-xl font-bold text-foreground font-heading">Histórico</h2>
          <BarChart2 className="h-6 w-6 text-muted-foreground" />
        </div>

        <div className="relative mb-6">
          <Search className="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground" />
          <input
            type="text"
            placeholder="Buscar"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            className="w-full bg-secondary rounded-full py-3 pl-12 pr-4 text-sm text-foreground placeholder:text-muted-foreground font-body outline-none focus:ring-2 focus:ring-ring"
          />
        </div>

        {loading ? (
          <p className="text-sm text-muted-foreground py-4">Carregando...</p>
        ) : (
          (() => {
            const filtered = transacoes.filter(t => {
              const term = searchTerm.toLowerCase();
              return !term || 
                (t.beneficiario_nome?.toLowerCase().includes(term)) ||
                t.descricao.toLowerCase().includes(term) ||
                t.categoria.toLowerCase().includes(term);
            });

            const grouped: Record<string, Transacao[]> = {};
            filtered.forEach(t => {
              const date = new Date(t.data_transacao);
              const today = new Date();
              const isToday = date.toDateString() === today.toDateString();
              const key = isToday ? "Hoje" : date.toLocaleDateString("pt-BR", { day: "2-digit", month: "long" });
              if (!grouped[key]) grouped[key] = [];
              grouped[key].push(t);
            });

            return Object.entries(grouped).map(([dateLabel, items]) => (
              <div key={dateLabel} className="mb-4">
                <p className="text-sm text-muted-foreground font-body mb-3">{dateLabel}</p>
                <div className="divide-y divide-border">
                  {items.map(t => {
                    const isPix = t.categoria === "PIX";
                    const time = new Date(t.data_transacao).toLocaleTimeString("pt-BR", { hour: "2-digit", minute: "2-digit" });
                    const catLabel = isPix ? "Pix" : t.categoria === "CARTAO" ? "Débito" : t.categoria;

                    return (
                      <div key={t.id} className="flex items-center gap-4 py-4">
                        <div className="w-12 h-12 rounded-full bg-secondary flex items-center justify-center">
                          {isPix ? (
                            <Send className="h-5 w-5 text-foreground" />
                          ) : (
                            <Wallet className="h-5 w-5 text-foreground" />
                          )}
                        </div>
                        <div className="flex-1 min-w-0">
                          <p className="text-sm font-semibold text-foreground font-heading truncate">
                            {t.beneficiario_nome || t.descricao}
                          </p>
                          <p className="text-xs text-muted-foreground font-body">
                            {time} · {catLabel}
                          </p>
                        </div>
                        <p className="text-sm font-semibold text-foreground font-heading whitespace-nowrap">
                          {formatCurrency(parseFloat(t.valor))}
                        </p>
                      </div>
                    );
                  })}
                </div>
              </div>
            ));
          })()
        )}
      </section>

      {/* ===== BOTTOM SHEET - Mais opções ===== */}
      {showMenu && (
        <div className="fixed inset-0 z-50 max-w-md mx-auto">
          {/* Overlay */}
          <div
            className="absolute inset-0 bg-black/50 transition-opacity"
            onClick={() => setShowMenu(false)}
          />
          {/* Sheet */}
          <div className="absolute bottom-0 left-0 right-0 bg-background rounded-t-2xl animate-in slide-in-from-bottom duration-300">
            {/* Handle */}
            <div className="flex justify-center pt-3 pb-1">
              <div className="w-10 h-1 rounded-full bg-muted-foreground/30" />
            </div>
            {/* Header */}
            <div className="flex items-center px-5 py-4">
              <button onClick={() => setShowMenu(false)} className="p-1">
                <X className="h-6 w-6 text-foreground" />
              </button>
              <p className="flex-1 text-center text-base font-semibold text-foreground font-heading pr-7">
                Mais opções
              </p>
            </div>
            {/* Menu items */}
            <div className="pb-8">
              <button
                className="w-full flex items-center gap-5 px-6 py-5 active:bg-muted/50 transition-colors"
                onClick={() => {
                  setShowMenu(false);
                  setShowMonthPicker(true);
                }}
              >
                <FileText className="h-6 w-6 text-foreground" />
                <span className="text-base text-foreground font-body">Pedir Extrato</span>
              </button>
              <button className="w-full flex items-center gap-5 px-6 py-5 active:bg-muted/50 transition-colors">
                <BarChart3 className="h-6 w-6 text-foreground" />
                <span className="text-base text-foreground font-body">Informações de rendimento</span>
              </button>
              <button className="w-full flex items-center gap-5 px-6 py-5 active:bg-muted/50 transition-colors">
                <Settings className="h-6 w-6 text-foreground" />
                <span className="text-base text-foreground font-body">Configurar conta</span>
              </button>
              <button className="w-full flex items-center gap-5 px-6 py-5 active:bg-muted/50 transition-colors">
                <Key className="h-6 w-6 text-foreground" />
                <span className="text-base text-foreground font-body">Configurar chaves Pix</span>
              </button>
            </div>
          </div>
        </div>
      )}

      {/* ===== FULL SCREEN SLIDE - Month Picker ===== */}
      {showMonthPicker && (
        <div
          className="fixed inset-0 z-[60] max-w-md mx-auto bg-background animate-in slide-in-from-right duration-300"
        >
          {/* Header */}
          <div className="px-5 pt-12 pb-2">
            <button onClick={() => { setShowMonthPicker(false); setSelectedMonth(null); }} className="p-1 mb-4">
              <X className="h-6 w-6 text-foreground" />
            </button>
            <h1 className="text-[26px] font-bold text-foreground font-heading leading-tight">
              Selecione o mês que você{"\n"}quer no seu extrato
            </h1>
          </div>

          {/* Month list */}
          <div className="flex-1 overflow-y-auto px-5 pb-28" style={{ maxHeight: "calc(100vh - 220px)" }}>
            {Object.entries(byYear)
              .sort(([a], [b]) => Number(b) - Number(a))
              .map(([year, months]) => (
                <div key={year} className="mt-6">
                  <p className="text-sm text-muted-foreground font-body mb-4">{year}</p>
                  <div className="space-y-2">
                    {months.map(m => {
                      const isSelected = selectedMonth === m.value;
                      return (
                        <button
                          key={m.value}
                          className="w-full flex items-center gap-4 py-4 active:bg-muted/30 transition-colors"
                          onClick={() => setSelectedMonth(m.value)}
                        >
                          <div
                            className={`w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors ${
                              isSelected
                                ? "border-primary"
                                : "border-muted-foreground/40"
                            }`}
                          >
                            {isSelected && (
                              <div className="w-3 h-3 rounded-full bg-primary" />
                            )}
                          </div>
                          <span className="text-base text-foreground font-body">{m.label}</span>
                        </button>
                      );
                    })}
                  </div>
                </div>
              ))}

            {/* Period selection */}
            <div className="mt-8">
              <h2 className="text-[22px] font-bold text-foreground font-heading leading-tight mb-2">
                Selecione o período que você{"\n"}quer no seu extrato
              </h2>
              <div className="space-y-2 mt-4">
                {[
                  { label: "3 últimos meses", value: "period-3" },
                  { label: "6 últimos meses", value: "period-6" },
                  { label: "1 ano", value: "period-12" },
                  { label: "2 anos", value: "period-24" },
                ].map(p => {
                  const isSelected = selectedMonth === p.value;
                  return (
                    <button
                      key={p.value}
                      className="w-full flex items-center gap-4 py-4 active:bg-muted/30 transition-colors"
                      onClick={() => setSelectedMonth(p.value)}
                    >
                      <div
                        className={`w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors ${
                          isSelected
                            ? "border-primary"
                            : "border-muted-foreground/40"
                        }`}
                      >
                        {isSelected && (
                          <div className="w-3 h-3 rounded-full bg-primary" />
                        )}
                      </div>
                      <span className="text-base text-foreground font-body">{p.label}</span>
                    </button>
                  );
                })}
              </div>
            </div>
          </div>

          {/* Fixed bottom button */}
          <div className="absolute bottom-0 left-0 right-0 p-5 pb-8 bg-background">
            <button
              onClick={handleExportExtrato}
              disabled={!selectedMonth}
              className={`w-full py-4 rounded-full text-base font-semibold font-heading transition-colors ${
                selectedMonth
                  ? "bg-primary text-primary-foreground active:opacity-90"
                  : "bg-muted text-muted-foreground"
              }`}
            >
              Exportar Extrato
            </button>
          </div>
        </div>
      )}
    </div>
  );
};

export default Saldo;
