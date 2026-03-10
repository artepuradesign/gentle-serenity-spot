import { useState, useEffect, useCallback } from "react";
import { useNavigate } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import {
  Table, TableBody, TableCell, TableHead, TableHeader, TableRow,
} from "@/components/ui/table";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import {
  Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter,
} from "@/components/ui/dialog";
import {
  LogOut, Plus, FileText, Users, TrendingUp, TrendingDown, DollarSign, Download, Pencil, Check, X, Copy,
} from "lucide-react";
import { DialogDescription } from "@/components/ui/dialog";
import { toast } from "sonner";
import { apiGet, apiPost } from "@/lib/api";
import logoNu from "@/assets/logonu.png";

interface Usuario {
  id: number;
  email: string;
  tipo_conta: string;
  status: string;
  nome: string;
  documento: string;
  telefone_pf: string | null;
  telefone_pj: string | null;
  conta_id: number;
  numero_conta: string;
  agencia: string;
  saldo: number;
  created_at: string;
}

interface ContaOption {
  conta_id: number;
  titular: string;
  documento: string;
  numero_conta: string;
}

const Admin = () => {
  const navigate = useNavigate();
  const [usuarios, setUsuarios] = useState<Usuario[]>([]);
  const [contas, setContas] = useState<ContaOption[]>([]);
  const [selectedConta, setSelectedConta] = useState<string>("");
  const [loading, setLoading] = useState(true);
  const [errorMsg, setErrorMsg] = useState("");

  // Auth check
  useEffect(() => {
    const user = localStorage.getItem("nu_user") || sessionStorage.getItem("nu_user");
    if (!user) { navigate("/login"); return; }
    try {
      const parsed = JSON.parse(user);
      if (!parsed.is_admin) navigate("/painel");
    } catch { navigate("/login"); }
  }, [navigate]);

  // Extrato state
  const [extratoData, setExtratoData] = useState<any>(null);
  const [extratoLoading, setExtratoLoading] = useState(false);

  // Nova transação
  const [novaTransacao, setNovaTransacao] = useState({
    data: "", tipo: "entrada" as "entrada" | "saida", descricao: "Transferência recebida pelo Pix",
    categoria: "PIX", valor: "", beneficiario: "", documento: "", banco: "", banco_codigo: "", agencia: "", conta: "",
  });

  // Auto-update description when tipo changes
  const handleTipoChange = (v: string) => {
    const tipo = v as "entrada" | "saida";
    const descricao = tipo === "entrada" ? "Transferência recebida pelo Pix" : "Transferência enviada pelo Pix";
    setNovaTransacao(p => ({ ...p, tipo, descricao }));
  };

  const fetchUsuarios = useCallback(async () => {
    try {
      const res = await apiGet<{ usuarios: Usuario[] }>("admin.php", { action: "usuarios" });
      setUsuarios(res.usuarios);
      const contasList: ContaOption[] = res.usuarios
        .filter(u => u.conta_id)
        .map(u => ({ conta_id: u.conta_id, titular: u.nome, documento: u.documento, numero_conta: u.numero_conta }));
      setContas(contasList);
      if (contasList.length > 0 && !selectedConta) setSelectedConta(String(contasList[0].conta_id));
    } catch (err) {
      const msg = err instanceof Error ? err.message : "Erro ao carregar usuários";
      setErrorMsg(msg);
      toast.error(msg);
    } finally { setLoading(false); }
  }, [selectedConta]);

  useEffect(() => { fetchUsuarios(); }, [fetchUsuarios]);

  const fetchExtrato = useCallback(async (contaId: string) => {
    if (!contaId) return;
    setExtratoLoading(true);
    try {
      const res = await apiGet<any>("admin.php", { action: "transacoes", conta_id: contaId });
      setExtratoData(res);
    } catch { toast.error("Erro ao carregar extrato"); }
    finally { setExtratoLoading(false); }
  }, []);

  useEffect(() => { if (selectedConta) fetchExtrato(selectedConta); }, [selectedConta, fetchExtrato]);

  const handleAddTransacao = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!selectedConta) { toast.error("Selecione uma conta primeiro"); return; }
    try {
      await apiPost("admin.php", {
        action: "criar_transacao",
        conta_id: parseInt(selectedConta),
        tipo: novaTransacao.tipo,
        categoria: novaTransacao.categoria,
        descricao: novaTransacao.descricao,
        valor: parseFloat(novaTransacao.valor),
        data_transacao: novaTransacao.data,
        beneficiario_nome: novaTransacao.beneficiario,
        beneficiario_documento: novaTransacao.documento,
        beneficiario_banco: novaTransacao.banco,
        beneficiario_banco_codigo: novaTransacao.banco_codigo,
        beneficiario_agencia: novaTransacao.agencia,
        beneficiario_conta: novaTransacao.conta,
      });
      toast.success("Lançamento adicionado com sucesso!");
      setNovaTransacao({
        data: "", tipo: "entrada", descricao: "Transferência recebida pelo Pix",
        categoria: "PIX", valor: "", beneficiario: "", documento: "", banco: "", banco_codigo: "", agencia: "", conta: "",
      });
      fetchExtrato(selectedConta);
      fetchUsuarios();
    } catch (err: unknown) {
      toast.error(err instanceof Error ? err.message : "Erro ao criar transação");
    }
  };

  const handleStatusChange = async (userId: number, newStatus: string) => {
    try {
      await apiPost("admin.php", { action: "ativar_usuario", usuario_id: userId, status: newStatus });
      toast.success(`Usuário ${newStatus === "ativo" ? "ativado" : "bloqueado"} com sucesso!`);
      fetchUsuarios();
    } catch { toast.error("Erro ao atualizar status"); }
  };

  const formatCurrency = (v: number) =>
    v.toLocaleString("pt-BR", { minimumFractionDigits: 2, maximumFractionDigits: 2 });

  const resumo = extratoData?.resumo || { saldo_inicial: 0, total_entradas: 0, total_saidas: 0, rendimento_liquido: 0, saldo_final: 0 };
  const contaInfo = extratoData?.conta || {};
  const movimentacoes = extratoData?.movimentacoes || {};
  const datasOrdenadas = Object.keys(movimentacoes).sort();
  const selectedUser = usuarios.find(u => String(u.conta_id) === selectedConta);

  return (
    <div className="min-h-screen bg-secondary/30">
      <header className="bg-background border-b border-border sticky top-0 z-50">
        <div className="container mx-auto px-6 h-16 flex items-center justify-between">
          <div className="flex items-center gap-4">
            <h1 className="text-2xl font-extrabold nu-text-gradient">NU</h1>
            <span className="text-sm text-muted-foreground font-medium bg-secondary px-3 py-1 rounded-full">Administração</span>
          </div>
          <Button variant="ghost" size="sm" onClick={() => {
            localStorage.removeItem("nu_user");
            sessionStorage.removeItem("nu_user");
            navigate("/login");
          }}>
            <LogOut className="h-4 w-4 mr-2" /> Sair
          </Button>
        </div>
      </header>

      <div className="container mx-auto px-6 py-8 max-w-6xl">
        {contas.length > 0 && (
          <div className="mb-6">
            <Label className="text-sm text-muted-foreground mb-2 block">Conta selecionada</Label>
            <Select value={selectedConta} onValueChange={setSelectedConta}>
              <SelectTrigger className="w-full md:w-96">
                <SelectValue placeholder="Selecione uma conta" />
              </SelectTrigger>
              <SelectContent>
                {contas.map(c => (
                  <SelectItem key={c.conta_id} value={String(c.conta_id)}>
                    {c.titular} - {c.documento} (Conta: {c.numero_conta})
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
          </div>
        )}

        {/* Summary Cards */}
        <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
          {[
            { label: "Saldo Atual", value: selectedUser ? parseFloat(String(selectedUser.saldo)) : 0, icon: DollarSign, color: "text-primary" },
            { label: "Total Entradas", value: resumo.total_entradas, icon: TrendingUp, color: "text-nu-green", prefix: "+" },
            { label: "Total Saídas", value: resumo.total_saidas, icon: TrendingDown, color: "text-destructive", prefix: "-" },
            { label: "Saldo Final Período", value: resumo.saldo_final, icon: DollarSign, color: "text-foreground" },
          ].map((c, i) => (
            <Card key={i} className="nu-card border-0">
              <CardContent className="pt-6">
                <div className="flex items-center gap-3 mb-2">
                  <c.icon className={`h-5 w-5 ${c.color}`} />
                  <span className="text-sm text-muted-foreground">{c.label}</span>
                </div>
                <p className={`text-2xl font-bold ${c.color}`}>
                  {c.prefix || ""}R$ {formatCurrency(c.value)}
                </p>
              </CardContent>
            </Card>
          ))}
        </div>

        <Tabs defaultValue="lancamentos">
          <TabsList className="mb-6">
            <TabsTrigger value="lancamentos" className="flex gap-2"><Plus className="h-4 w-4" /> Lançamentos</TabsTrigger>
            <TabsTrigger value="extrato" className="flex gap-2"><FileText className="h-4 w-4" /> Extrato</TabsTrigger>
            <TabsTrigger value="clientes" className="flex gap-2"><Users className="h-4 w-4" /> Clientes</TabsTrigger>
            <TabsTrigger value="exportar" className="flex gap-2"><Download className="h-4 w-4" /> Exportar Extrato</TabsTrigger>
          </TabsList>

          {/* Lançamentos */}
          <TabsContent value="lancamentos">
            {/* Novo Lançamento */}
            <Card className="nu-card border-0 mb-6">
              <CardHeader>
                <CardTitle className="text-lg text-foreground">Novo Lançamento</CardTitle>
              </CardHeader>
              <CardContent>
                <form onSubmit={handleAddTransacao} className="space-y-4">
                  <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                      <Label>Data *</Label>
                      <Input type="date" required value={novaTransacao.data} onChange={e => setNovaTransacao(p => ({ ...p, data: e.target.value }))} />
                    </div>
                    <div>
                      <Label>Tipo *</Label>
                      <Select value={novaTransacao.tipo} onValueChange={handleTipoChange}>
                        <SelectTrigger><SelectValue /></SelectTrigger>
                        <SelectContent>
                          <SelectItem value="entrada">Entrada</SelectItem>
                          <SelectItem value="saida">Saída</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div>
                      <Label>Valor (R$) *</Label>
                      <Input type="number" step="0.01" required value={novaTransacao.valor} onChange={e => setNovaTransacao(p => ({ ...p, valor: e.target.value }))} placeholder="0,00" />
                    </div>
                    <div>
                      <Label>Categoria</Label>
                      <Select value={novaTransacao.categoria} onValueChange={v => setNovaTransacao(p => ({ ...p, categoria: v }))}>
                        <SelectTrigger><SelectValue /></SelectTrigger>
                        <SelectContent>
                          <SelectItem value="PIX">PIX</SelectItem>
                          <SelectItem value="TED">TED</SelectItem>
                          <SelectItem value="BOLETO">Boleto</SelectItem>
                          <SelectItem value="ESTORNO">Estorno</SelectItem>
                          <SelectItem value="RENDIMENTO">Rendimento</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div className="md:col-span-2">
                      <Label>Descrição</Label>
                      <Input value={novaTransacao.descricao} onChange={e => setNovaTransacao(p => ({ ...p, descricao: e.target.value }))} />
                    </div>
                    <div>
                      <Label>Beneficiário/Pagador *</Label>
                      <Input required value={novaTransacao.beneficiario} onChange={e => setNovaTransacao(p => ({ ...p, beneficiario: e.target.value }))} />
                    </div>
                    <div>
                      <Label>CPF/CNPJ</Label>
                      <Input value={novaTransacao.documento} onChange={e => setNovaTransacao(p => ({ ...p, documento: e.target.value }))} />
                    </div>
                    <div>
                      <Label>Banco</Label>
                      <Input value={novaTransacao.banco} onChange={e => setNovaTransacao(p => ({ ...p, banco: e.target.value }))} />
                    </div>
                    <div>
                      <Label>Código do Banco</Label>
                      <Input value={novaTransacao.banco_codigo} onChange={e => setNovaTransacao(p => ({ ...p, banco_codigo: e.target.value }))} placeholder="0033" />
                    </div>
                    <div>
                      <Label>Agência</Label>
                      <Input value={novaTransacao.agencia} onChange={e => setNovaTransacao(p => ({ ...p, agencia: e.target.value }))} />
                    </div>
                    <div>
                      <Label>Conta</Label>
                      <Input value={novaTransacao.conta} onChange={e => setNovaTransacao(p => ({ ...p, conta: e.target.value }))} />
                    </div>
                  </div>
                  <Button type="submit" variant="hero">
                    <Plus className="h-4 w-4 mr-2" /> Adicionar lançamento
                  </Button>
                </form>
              </CardContent>
            </Card>

            {/* Gerador de Extrato */}
            <GeradorExtrato
              selectedConta={selectedConta}
              usuarios={usuarios}
              onGenerated={() => { fetchExtrato(selectedConta); fetchUsuarios(); }}
            />
          </TabsContent>

          {/* Extrato */}
          <TabsContent value="extrato">
            <Card className="nu-card border-0">
              <CardContent className="pt-6">
                {extratoLoading ? (
                  <p className="text-muted-foreground text-center py-8">Carregando extrato...</p>
                ) : !selectedConta ? (
                  <p className="text-muted-foreground text-center py-8">Selecione uma conta para visualizar o extrato.</p>
                ) : (
                  <ExtratoPreview
                    contaInfo={contaInfo}
                    resumo={resumo}
                    movimentacoes={movimentacoes}
                    datasOrdenadas={datasOrdenadas}
                    extratoData={extratoData}
                    formatCurrency={formatCurrency}
                    onTransacaoUpdated={() => fetchExtrato(selectedConta)}
                  />
                )}
              </CardContent>
            </Card>
          </TabsContent>

          {/* Clientes */}
          <TabsContent value="clientes">
            <Card className="nu-card border-0">
              <CardHeader>
                <CardTitle className="text-lg text-foreground">Clientes cadastrados</CardTitle>
              </CardHeader>
              <CardContent>
                {loading ? (
                  <p className="text-muted-foreground">Carregando...</p>
                ) : errorMsg ? (
                  <div className="text-center py-4">
                    <p className="text-destructive mb-2">Erro ao carregar clientes:</p>
                    <p className="text-sm text-muted-foreground">{errorMsg}</p>
                    <Button variant="outline" size="sm" className="mt-4" onClick={fetchUsuarios}>Tentar novamente</Button>
                  </div>
                ) : usuarios.length === 0 ? (
                  <p className="text-muted-foreground">Nenhum cliente cadastrado ainda.</p>
                ) : (
                  <Table>
                    <TableHeader>
                      <TableRow>
                        <TableHead>Nome</TableHead>
                        <TableHead>Documento</TableHead>
                        <TableHead>Tipo</TableHead>
                        <TableHead>E-mail</TableHead>
                        <TableHead>Conta</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead className="text-right">Saldo</TableHead>
                        <TableHead>Ações</TableHead>
                      </TableRow>
                    </TableHeader>
                    <TableBody>
                      {usuarios.map(u => (
                        <TableRow key={u.id}>
                          <TableCell className="font-medium">{u.nome || "—"}</TableCell>
                          <TableCell className="text-sm">{u.documento || "—"}</TableCell>
                          <TableCell>
                            <span className="text-xs font-medium px-2 py-1 rounded-full bg-secondary text-foreground">{u.tipo_conta}</span>
                          </TableCell>
                          <TableCell className="text-sm">{u.email}</TableCell>
                          <TableCell className="text-sm">{u.numero_conta || "—"}</TableCell>
                          <TableCell>
                            <span className={`text-xs font-medium px-2 py-1 rounded-full ${
                              u.status === "ativo" ? "bg-nu-green/10 text-nu-green" :
                              u.status === "pendente" ? "bg-yellow-100 text-yellow-700" :
                              "bg-destructive/10 text-destructive"
                            }`}>
                              {u.status === "ativo" ? "Ativo" : u.status === "pendente" ? "Pendente" : "Bloqueado"}
                            </span>
                          </TableCell>
                          <TableCell className="text-right font-medium">
                            R$ {formatCurrency(parseFloat(String(u.saldo || 0)))}
                          </TableCell>
                          <TableCell>
                            {u.status === "pendente" && (
                              <Button size="sm" variant="outline" className="text-nu-green border-nu-green hover:bg-nu-green/10" onClick={() => handleStatusChange(u.id, "ativo")}>Ativar</Button>
                            )}
                            {u.status === "ativo" && (
                              <Button size="sm" variant="outline" className="text-destructive border-destructive hover:bg-destructive/10" onClick={() => handleStatusChange(u.id, "bloqueado")}>Bloquear</Button>
                            )}
                            {u.status === "bloqueado" && (
                              <Button size="sm" variant="outline" className="text-nu-green border-nu-green hover:bg-nu-green/10" onClick={() => handleStatusChange(u.id, "ativo")}>Reativar</Button>
                            )}
                          </TableCell>
                        </TableRow>
                      ))}
                    </TableBody>
                  </Table>
                )}
              </CardContent>
            </Card>
          </TabsContent>

          {/* Exportar Extrato */}
          <TabsContent value="exportar">
            <ExportarExtrato selectedConta={selectedConta} contaInfo={contaInfo} />
          </TabsContent>
        </Tabs>
      </div>
    </div>
  );
};

// ============================================================
// EDIT TRANSACTION MODAL
// ============================================================
function EditTransacaoModal({ transacao, open, onClose, onSaved }: {
  transacao: any; open: boolean; onClose: () => void; onSaved: () => void;
}) {
  const [form, setForm] = useState({
    data_transacao: "",
    descricao: "",
    valor: "",
    beneficiario_nome: "",
    beneficiario_documento: "",
    beneficiario_banco: "",
    beneficiario_banco_codigo: "",
    beneficiario_agencia: "",
    beneficiario_conta: "",
  });
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    if (transacao) {
      setForm({
        data_transacao: transacao.data_transacao ? transacao.data_transacao.substring(0, 10) : "",
        descricao: transacao.descricao || "",
        valor: transacao.valor || "",
        beneficiario_nome: transacao.beneficiario_nome || "",
        beneficiario_documento: transacao.beneficiario_documento || "",
        beneficiario_banco: transacao.beneficiario_banco || "",
        beneficiario_banco_codigo: transacao.beneficiario_banco_codigo || "",
        beneficiario_agencia: transacao.beneficiario_agencia || "",
        beneficiario_conta: transacao.beneficiario_conta || "",
      });
    }
  }, [transacao]);

  const handleSave = async () => {
    setSaving(true);
    try {
      await apiPost("admin.php", {
        action: "editar_transacao",
        transacao_id: transacao.id,
        ...form,
        valor: parseFloat(form.valor),
      });
      toast.success("Transação atualizada!");
      onSaved();
      onClose();
    } catch {
      toast.error("Erro ao atualizar transação");
    } finally { setSaving(false); }
  };

  return (
    <Dialog open={open} onOpenChange={v => { if (!v) onClose(); }}>
      <DialogContent className="sm:max-w-lg">
        <DialogHeader>
          <DialogTitle>Editar Transação</DialogTitle>
          <DialogDescription>Altere os campos desejados e clique em salvar.</DialogDescription>
        </DialogHeader>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 py-4">
          <div>
            <Label>Data</Label>
            <Input type="date" value={form.data_transacao} onChange={e => setForm(p => ({ ...p, data_transacao: e.target.value }))} />
          </div>
          <div>
            <Label>Valor (R$)</Label>
            <Input type="number" step="0.01" value={form.valor} onChange={e => setForm(p => ({ ...p, valor: e.target.value }))} />
          </div>
          <div className="md:col-span-2">
            <Label>Descrição</Label>
            <Input value={form.descricao} onChange={e => setForm(p => ({ ...p, descricao: e.target.value }))} />
          </div>
          <div>
            <Label>Beneficiário/Pagador</Label>
            <Input value={form.beneficiario_nome} onChange={e => setForm(p => ({ ...p, beneficiario_nome: e.target.value }))} />
          </div>
          <div>
            <Label>CPF/CNPJ</Label>
            <Input value={form.beneficiario_documento} onChange={e => setForm(p => ({ ...p, beneficiario_documento: e.target.value }))} />
          </div>
          <div>
            <Label>Banco</Label>
            <Input value={form.beneficiario_banco} onChange={e => setForm(p => ({ ...p, beneficiario_banco: e.target.value }))} />
          </div>
          <div>
            <Label>Código do Banco</Label>
            <Input value={form.beneficiario_banco_codigo} onChange={e => setForm(p => ({ ...p, beneficiario_banco_codigo: e.target.value }))} />
          </div>
          <div>
            <Label>Agência</Label>
            <Input value={form.beneficiario_agencia} onChange={e => setForm(p => ({ ...p, beneficiario_agencia: e.target.value }))} />
          </div>
          <div>
            <Label>Conta</Label>
            <Input value={form.beneficiario_conta} onChange={e => setForm(p => ({ ...p, beneficiario_conta: e.target.value }))} />
          </div>
        </div>
        <DialogFooter>
          <Button variant="outline" onClick={onClose}>Cancelar</Button>
          <Button variant="hero" onClick={handleSave} disabled={saving}>
            {saving ? "Salvando..." : "Salvar alterações"}
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  );
}

// ============================================================
// GERADOR DE EXTRATO
// ============================================================
function GeradorExtrato({ selectedConta, usuarios, onGenerated }: {
  selectedConta: string; usuarios: Usuario[]; onGenerated: () => void;
}) {
  const [dataInicio, setDataInicio] = useState("");
  const [dataFim, setDataFim] = useState("");
  const [tipo, setTipo] = useState<"entrada" | "saida">("entrada");
  const [categoria, setCategoria] = useState("PIX");
  const [descricao, setDescricao] = useState("Transferência recebida pelo Pix");
  const [valorFixo, setValorFixo] = useState("");
  const [valorAleatorio, setValorAleatorio] = useState(false);
  const [valorMin, setValorMin] = useState("");
  const [valorMax, setValorMax] = useState("");
  const [beneficiario, setBeneficiario] = useState("");
  const [documento, setDocumento] = useState("");
  const [banco, setBanco] = useState("");
  const [bancoCodigo, setBancoCodigo] = useState("");
  const [agencia, setAgencia] = useState("");
  const [conta, setConta] = useState("");
  const [frequencia, setFrequencia] = useState<"diario" | "semanal" | "mensal">("diario");
  const [generating, setGenerating] = useState(false);

  const handleTipoChangeGen = (v: string) => {
    const t = v as "entrada" | "saida";
    setTipo(t);
    setDescricao(t === "entrada" ? "Transferência recebida pelo Pix" : "Transferência enviada pelo Pix");
  };

  const generateDates = (): string[] => {
    if (!dataInicio || !dataFim) return [];
    const dates: string[] = [];
    const start = new Date(dataInicio + "T12:00:00");
    const end = new Date(dataFim + "T12:00:00");
    const current = new Date(start);

    while (current <= end) {
      dates.push(current.toISOString().substring(0, 10));
      if (frequencia === "diario") current.setDate(current.getDate() + 1);
      else if (frequencia === "semanal") current.setDate(current.getDate() + 7);
      else current.setMonth(current.getMonth() + 1);
    }
    return dates;
  };

  const handleGenerate = async () => {
    if (!selectedConta) { toast.error("Selecione uma conta primeiro"); return; }
    if (!dataInicio || !dataFim) { toast.error("Selecione o período"); return; }
    if (!valorAleatorio && !valorFixo) { toast.error("Informe o valor"); return; }
    if (valorAleatorio && (!valorMin || !valorMax)) { toast.error("Informe os valores mínimo e máximo"); return; }

    const dates = generateDates();
    if (dates.length === 0) { toast.error("Nenhuma data gerada no período"); return; }

    setGenerating(true);
    let successCount = 0;

    for (const date of dates) {
      let valor: number;
      if (valorAleatorio) {
        const min = parseFloat(valorMin);
        const max = parseFloat(valorMax);
        valor = Math.round((Math.random() * (max - min) + min) * 100) / 100;
      } else {
        valor = parseFloat(valorFixo);
      }

      try {
        await apiPost("admin.php", {
          action: "criar_transacao",
          conta_id: parseInt(selectedConta),
          tipo,
          categoria,
          descricao,
          valor,
          data_transacao: date,
          beneficiario_nome: beneficiario,
          beneficiario_documento: documento,
          beneficiario_banco: banco,
          beneficiario_banco_codigo: bancoCodigo,
          beneficiario_agencia: agencia,
          beneficiario_conta: conta,
        });
        successCount++;
      } catch {
        // continue
      }
    }

    setGenerating(false);
    toast.success(`${successCount} movimentações geradas com sucesso!`);
    onGenerated();
  };

  return (
    <Card className="nu-card border-0">
      <CardHeader>
        <CardTitle className="text-lg text-foreground flex items-center gap-2">
          <Copy className="h-5 w-5" /> Gerador de Extrato
        </CardTitle>
        <p className="text-sm text-muted-foreground">Gere múltiplas movimentações de uma vez, repetindo em várias datas com valores fixos ou aleatórios.</p>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <Label>Data início *</Label>
              <Input type="date" value={dataInicio} onChange={e => setDataInicio(e.target.value)} />
            </div>
            <div>
              <Label>Data fim *</Label>
              <Input type="date" value={dataFim} onChange={e => setDataFim(e.target.value)} />
            </div>
            <div>
              <Label>Frequência</Label>
              <Select value={frequencia} onValueChange={v => setFrequencia(v as any)}>
                <SelectTrigger><SelectValue /></SelectTrigger>
                <SelectContent>
                  <SelectItem value="diario">Diário</SelectItem>
                  <SelectItem value="semanal">Semanal</SelectItem>
                  <SelectItem value="mensal">Mensal</SelectItem>
                </SelectContent>
              </Select>
            </div>
            <div>
              <Label>Tipo *</Label>
              <Select value={tipo} onValueChange={handleTipoChangeGen}>
                <SelectTrigger><SelectValue /></SelectTrigger>
                <SelectContent>
                  <SelectItem value="entrada">Entrada</SelectItem>
                  <SelectItem value="saida">Saída</SelectItem>
                </SelectContent>
              </Select>
            </div>
            <div>
              <Label>Categoria</Label>
              <Select value={categoria} onValueChange={setCategoria}>
                <SelectTrigger><SelectValue /></SelectTrigger>
                <SelectContent>
                  <SelectItem value="PIX">PIX</SelectItem>
                  <SelectItem value="TED">TED</SelectItem>
                  <SelectItem value="BOLETO">Boleto</SelectItem>
                  <SelectItem value="ESTORNO">Estorno</SelectItem>
                  <SelectItem value="RENDIMENTO">Rendimento</SelectItem>
                </SelectContent>
              </Select>
            </div>
            <div>
              <Label>Descrição</Label>
              <Input value={descricao} onChange={e => setDescricao(e.target.value)} />
            </div>
          </div>

          {/* Valor */}
          <div className="border border-border rounded-lg p-4">
            <div className="flex items-center gap-4 mb-3">
              <Label className="text-sm font-semibold">Valor</Label>
              <label className="flex items-center gap-2 text-sm cursor-pointer">
                <input type="checkbox" checked={valorAleatorio} onChange={e => setValorAleatorio(e.target.checked)} className="rounded" />
                Valores aleatórios
              </label>
            </div>
            {valorAleatorio ? (
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <Label>Mínimo (R$)</Label>
                  <Input type="number" step="0.01" value={valorMin} onChange={e => setValorMin(e.target.value)} placeholder="100.00" />
                </div>
                <div>
                  <Label>Máximo (R$)</Label>
                  <Input type="number" step="0.01" value={valorMax} onChange={e => setValorMax(e.target.value)} placeholder="5000.00" />
                </div>
              </div>
            ) : (
              <div>
                <Label>Valor fixo (R$) *</Label>
                <Input type="number" step="0.01" value={valorFixo} onChange={e => setValorFixo(e.target.value)} placeholder="0,00" />
              </div>
            )}
          </div>

          {/* Beneficiário */}
          <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <Label>Beneficiário/Pagador</Label>
              <Input value={beneficiario} onChange={e => setBeneficiario(e.target.value)} />
            </div>
            <div>
              <Label>CPF/CNPJ</Label>
              <Input value={documento} onChange={e => setDocumento(e.target.value)} />
            </div>
            <div>
              <Label>Banco</Label>
              <Input value={banco} onChange={e => setBanco(e.target.value)} />
            </div>
            <div>
              <Label>Código do Banco</Label>
              <Input value={bancoCodigo} onChange={e => setBancoCodigo(e.target.value)} placeholder="0033" />
            </div>
            <div>
              <Label>Agência</Label>
              <Input value={agencia} onChange={e => setAgencia(e.target.value)} />
            </div>
            <div>
              <Label>Conta</Label>
              <Input value={conta} onChange={e => setConta(e.target.value)} />
            </div>
          </div>

          {dataInicio && dataFim && (
            <p className="text-sm text-muted-foreground">
              📊 Serão geradas <strong>{generateDates().length}</strong> movimentações ({frequencia === "diario" ? "diárias" : frequencia === "semanal" ? "semanais" : "mensais"})
            </p>
          )}

          <Button variant="hero" onClick={handleGenerate} disabled={generating}>
            {generating ? "Gerando..." : <><Copy className="h-4 w-4 mr-2" /> Gerar movimentações</>}
          </Button>
        </div>
      </CardContent>
    </Card>
  );
}

// ============================================================
// EXTRATO PREVIEW (with edit modal on all fields)
// ============================================================
function ExtratoPreview({ contaInfo, resumo, movimentacoes, datasOrdenadas, extratoData, formatCurrency, onTransacaoUpdated }: {
  contaInfo: any; resumo: any; movimentacoes: any; datasOrdenadas: string[]; extratoData: any; formatCurrency: (v: number) => string; onTransacaoUpdated: () => void;
}) {
  const [editingTransacao, setEditingTransacao] = useState<any>(null);
  const [saldoInicial, setSaldoInicial] = useState<number>(resumo.saldo_inicial || 0);
  const [editingSaldoInicial, setEditingSaldoInicial] = useState(false);
  const [saldoInicialInput, setSaldoInicialInput] = useState("");

  useEffect(() => {
    setSaldoInicial(resumo.saldo_inicial || 0);
  }, [resumo.saldo_inicial]);

  const fmtPeriodo = (d: string) =>
    new Date(d + "T12:00:00").toLocaleDateString("pt-BR", { day: "2-digit", month: "long", year: "numeric" }).toUpperCase();

  const fmtDia = (d: string) => {
    const dt = new Date(d + "T12:00:00");
    const day = String(dt.getDate()).padStart(2, "0");
    const months = ["JAN","FEV","MAR","ABR","MAI","JUN","JUL","AGO","SET","OUT","NOV","DEZ"];
    return `${day} ${months[dt.getMonth()]} ${dt.getFullYear()}`;
  };

  const saldoPorDia: Record<string, number> = {};
  let saldoAcumulado = saldoInicial;
  for (const dia of datasOrdenadas) {
    const trans = movimentacoes[dia];
    for (const t of trans) {
      if (t.tipo === "entrada") saldoAcumulado += parseFloat(t.valor);
      else saldoAcumulado -= parseFloat(t.valor);
    }
    saldoPorDia[dia] = saldoAcumulado;
  }

  const pencilBtn = (t: any) => (
    <button onClick={() => setEditingTransacao(t)} className="text-muted-foreground hover:text-foreground p-0.5 opacity-50 hover:opacity-100 print:hidden">
      <Pencil className="h-3 w-3" />
    </button>
  );

  const renderTransacaoRow = (t: any, i: number) => (
    <tr key={t.id || i}>
      <td style={{ padding: "4px 16px 4px 0" }}></td>
      <td style={{ padding: "4px 0", verticalAlign: "top", width: "200px" }}>
        <span className="inline-flex items-center gap-1">
          {t.descricao} {pencilBtn(t)}
        </span>
      </td>
      <td style={{ padding: "4px 8px", verticalAlign: "top", color: "#555", fontSize: "10px", lineHeight: "1.6" }}>
        <span className="inline-flex items-center gap-1 flex-wrap">
          {t.beneficiario_nome} - {t.beneficiario_documento} - {t.beneficiario_banco}
          {t.beneficiario_banco_codigo ? ` (${t.beneficiario_banco_codigo})` : ""}
          {" "}Agência: {t.beneficiario_agencia} Conta: {t.beneficiario_conta}
          {pencilBtn(t)}
        </span>
      </td>
      <td style={{ textAlign: "right", padding: "4px 0 4px 24px", verticalAlign: "top", whiteSpace: "nowrap" }}>
        <span className="inline-flex items-center gap-1">
          {formatCurrency(parseFloat(t.valor))} {pencilBtn(t)}
        </span>
      </td>
    </tr>
  );

  return (
    <>
      <EditTransacaoModal
        transacao={editingTransacao}
        open={!!editingTransacao}
        onClose={() => setEditingTransacao(null)}
        onSaved={onTransacaoUpdated}
      />
      <div className="bg-white text-black p-8 max-w-[210mm] mx-auto" style={{ fontFamily: "'Graphik', 'Helvetica Neue', Helvetica, Arial, sans-serif", fontSize: "11px", lineHeight: "1.5" }}>
        {/* HEADER */}
        <div className="flex justify-between items-start mb-12">
          <img src={logoNu} alt="Nu" style={{ height: "32px", width: "auto", marginLeft: "30px" }} />
          <div className="text-right" style={{ fontSize: "12px", lineHeight: "1.6" }}>
            <p>{contaInfo.titular || "—"}</p>
            <p>
              <span style={{ fontWeight: 700, color: "#222" }}>{contaInfo.tipo_conta === "PJ" ? "CNPJ" : "CPF"}</span>{"  "}{contaInfo.documento || "—"}{"  "}
              <span style={{ fontWeight: 700 }}>Agência</span>{"  "}{contaInfo.agencia || "0001"}{"  "}
              <span style={{ fontWeight: 700 }}>Conta</span>
            </p>
            <p>{contaInfo.numero_conta || "—"}</p>
          </div>
        </div>

        {/* PERÍODO */}
        <div style={{ borderBottom: "2px solid #ccc", paddingBottom: "8px", marginBottom: "24px" }}>
          <div className="flex justify-between items-baseline">
            <span style={{ fontWeight: 700, fontSize: "12px" }}>
              {extratoData?.periodo ? `${fmtPeriodo(extratoData.periodo.inicio)} a ${fmtPeriodo(extratoData.periodo.fim)}` : "—"}
            </span>
            <span style={{ fontSize: "12px", color: "#666" }}>VALORES EM R$</span>
          </div>
        </div>

        {/* RESUMO */}
        <div className="flex justify-between items-start" style={{ marginBottom: "24px" }}>
          <div style={{ paddingTop: "8px" }}>
            <p style={{ fontSize: "11px", color: "#000", marginBottom: "6px", fontWeight: 700 }}>Saldo final do período</p>
            <p style={{ fontSize: "22px", fontWeight: 700, color: "#820AD1", lineHeight: "1.2" }}>R$ {formatCurrency(saldoInicial + resumo.total_entradas - resumo.total_saidas + resumo.rendimento_liquido)}</p>
          </div>
          <table style={{ fontSize: "12px", borderCollapse: "collapse", minWidth: "320px" }}>
            <tbody>
              <tr>
                <td style={{ fontWeight: 700, padding: "3px 16px 3px 0" }}>Saldo inicial</td>
                <td style={{ textAlign: "right", padding: "3px 0" }}>
                  {editingSaldoInicial ? (
                    <span className="inline-flex items-center gap-1 print:hidden">
                      <input
                        type="number"
                        step="0.01"
                        value={saldoInicialInput}
                        onChange={e => setSaldoInicialInput(e.target.value)}
                        onKeyDown={e => {
                          if (e.key === "Enter") {
                            setSaldoInicial(parseFloat(saldoInicialInput) || 0);
                            setEditingSaldoInicial(false);
                          }
                          if (e.key === "Escape") setEditingSaldoInicial(false);
                        }}
                        autoFocus
                        className="w-28 text-right border rounded px-1 py-0.5 text-xs"
                      />
                      <button onClick={() => { setSaldoInicial(parseFloat(saldoInicialInput) || 0); setEditingSaldoInicial(false); }} className="text-green-600 hover:text-green-800">✓</button>
                      <button onClick={() => setEditingSaldoInicial(false)} className="text-red-500 hover:text-red-700">✕</button>
                    </span>
                  ) : (
                    <span className="inline-flex items-center gap-1">
                      {formatCurrency(saldoInicial)}
                      <button onClick={() => { setSaldoInicialInput(String(saldoInicial)); setEditingSaldoInicial(true); }} className="text-muted-foreground hover:text-foreground p-0.5 opacity-50 hover:opacity-100 print:hidden">
                        <Pencil className="h-3 w-3" />
                      </button>
                    </span>
                  )}
                </td>
              </tr>
              <tr><td style={{ padding: "3px 16px 3px 0", color: "#444" }}>Rendimento líquido</td><td style={{ textAlign: "right", padding: "3px 0" }}>+{formatCurrency(resumo.rendimento_liquido)}</td></tr>
              <tr><td style={{ padding: "3px 16px 3px 0", color: "#444" }}>Total de entradas</td><td style={{ textAlign: "right", padding: "3px 0" }}>+{formatCurrency(resumo.total_entradas)}</td></tr>
              <tr><td style={{ padding: "3px 16px 3px 0", color: "#444" }}>Total de saídas</td><td style={{ textAlign: "right", padding: "3px 0" }}>-{formatCurrency(resumo.total_saidas)}</td></tr>
              <tr><td style={{ fontWeight: 700, padding: "6px 16px 3px 0" }}>Saldo final do período</td><td style={{ fontWeight: 700, textAlign: "right", padding: "6px 0 3px 0" }}>{formatCurrency(saldoInicial + resumo.total_entradas - resumo.total_saidas + resumo.rendimento_liquido)}</td></tr>
            </tbody>
          </table>
        </div>

        {/* MOVIMENTAÇÕES */}
        <div style={{ borderBottom: "2px solid #ccc", marginBottom: "4px" }}></div>
        <div style={{ marginBottom: "16px" }}>
          <span style={{ fontWeight: 700, fontSize: "12px" }}>Movimentações</span>
        </div>

        {datasOrdenadas.length === 0 && <p style={{ textAlign: "center", color: "#999", padding: "20px 0" }}>Nenhuma movimentação encontrada.</p>}

        {datasOrdenadas.map(dia => {
          const trans = movimentacoes[dia];
          const entradas = trans.filter((t: any) => t.tipo === "entrada");
          const saidas = trans.filter((t: any) => t.tipo === "saida");
          const totalE = entradas.reduce((s: number, t: any) => s + parseFloat(t.valor), 0);
          const totalS = saidas.reduce((s: number, t: any) => s + parseFloat(t.valor), 0);
          const dateShownInEntradas = entradas.length > 0;

          return (
            <div key={dia} style={{ marginBottom: "0" }}>
              <table style={{ width: "100%", borderCollapse: "collapse", fontSize: "11px" }}>
                <tbody>
                  {entradas.length > 0 && (
                    <>
                      <tr>
                        <td style={{ width: "110px", verticalAlign: "top", padding: "10px 16px 10px 0", color: "#222", fontWeight: 700 }}>
                          <span className="inline-flex items-center gap-1">{fmtDia(dia)} {pencilBtn(entradas[0])}</span>
                        </td>
                        <td style={{ fontWeight: 700, padding: "10px 0", verticalAlign: "top" }}>Total de entradas</td>
                        <td style={{ padding: "10px 0" }}></td>
                        <td style={{ fontWeight: 700, textAlign: "right", padding: "10px 0 10px 24px", whiteSpace: "nowrap", verticalAlign: "top" }}>+ {formatCurrency(totalE)}</td>
                      </tr>
                      {entradas.map((t: any, i: number) => renderTransacaoRow(t, i))}
                    </>
                  )}
                  {saidas.length > 0 && (
                    <>
                      <tr>
                        <td style={{ width: "110px", verticalAlign: "top", padding: "10px 16px 10px 0", color: "#222", fontWeight: 700 }}>
                          {!dateShownInEntradas ? <span className="inline-flex items-center gap-1">{fmtDia(dia)} {pencilBtn(saidas[0])}</span> : ""}
                        </td>
                        <td style={{ fontWeight: 700, padding: "10px 0", verticalAlign: "top" }}>Total de saídas</td>
                        <td style={{ padding: "10px 0" }}></td>
                        <td style={{ fontWeight: 700, textAlign: "right", padding: "10px 0 10px 24px", whiteSpace: "nowrap", verticalAlign: "top" }}>- {formatCurrency(totalS)}</td>
                      </tr>
                      {saidas.map((t: any, i: number) => renderTransacaoRow(t, i))}
                    </>
                  )}
                  <tr style={{ borderBottom: "2px solid #ccc" }}>
                    <td style={{ padding: "10px 16px 10px 0" }}></td>
                    <td style={{ fontWeight: 700, padding: "10px 0" }}>Saldo do dia</td>
                    <td style={{ padding: "10px 0" }}></td>
                    <td style={{ fontWeight: 700, textAlign: "right", padding: "10px 0 10px 24px" }}>{formatCurrency(saldoPorDia[dia])}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          );
        })}

        {/* Rodapé */}
        <div style={{ marginTop: "40px", borderTop: "1px solid #ddd", paddingTop: "16px", fontSize: "10px", color: "#555", lineHeight: "1.6" }}>
          <p>O saldo líquido corresponde ao total de depósitos e rendimentos em conta, não considerando movimentações feitas após a data mencionada.</p>
          <p>Não nos responsabilizamos pelo uso indevido ou por alterações das informações originalmente contidas neste documento após envio.</p>
          <p>Asseguramos a autenticidade destas movimentações e das informações aqui citadas.</p>
        </div>
        <div className="flex justify-between items-start" style={{ marginTop: "20px", fontSize: "11.5px", lineHeight: "1.6", color: "#222" }}>
          <div>
            <p style={{ fontWeight: 700 }}>Nu Financeira S.A. - Sociedade de Credito, Financiamento</p>
            <p style={{ fontWeight: 700 }}>e Investimento</p>
            <p>CNPJ: 30.680.829/0001-43</p>
          </div>
          <div style={{ textAlign: "right" }}>
            <p style={{ fontWeight: 700 }}>Nu Pagamentos S.A. - Instituição de Pagamento</p>
            <p>CNPJ: 18.236.120/0001-58</p>
          </div>
        </div>
        <div style={{ marginTop: "16px", fontSize: "10px", color: "#888", lineHeight: "1.6" }}>
          <p>Tem alguma dúvida? Mande uma mensagem para nosso time de atendimento pelo chat do app.</p>
          <div className="flex justify-between" style={{ marginTop: "12px", paddingRight: "15px" }}>
            <span style={{ marginLeft: "15px" }}>Extrato gerado dia {new Date().toLocaleDateString("pt-BR", { day: "2-digit", month: "long", year: "numeric" })} às {new Date().toLocaleTimeString("pt-BR", { hour: "2-digit", minute: "2-digit" })}</span>
            <span>1 de 1</span>
          </div>
        </div>
      </div>
    </>
  );
}

// Export component
function ExportarExtrato({ selectedConta, contaInfo }: { selectedConta: string; contaInfo: any }) {
  const navigate = useNavigate();
  const [dataInicio, setDataInicio] = useState("");
  const [dataFim, setDataFim] = useState("");

  const handleContinuar = () => {
    if (!selectedConta) { toast.error("Selecione uma conta primeiro"); return; }
    if (!dataInicio || !dataFim) { toast.error("Selecione o período"); return; }
    navigate(`/extrato-export?conta_id=${selectedConta}&data_inicio=${dataInicio}&data_fim=${dataFim}`);
  };

  return (
    <Card className="nu-card border-0">
      <CardHeader>
        <CardTitle className="text-lg text-foreground">Exportar Extrato em PDF</CardTitle>
      </CardHeader>
      <CardContent>
        <p className="text-sm text-muted-foreground mb-6">
          Selecione o período desejado para gerar uma pré-visualização do extrato no formato A4, pronto para exportar como PDF.
        </p>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
          <div>
            <Label>Data início *</Label>
            <Input type="date" value={dataInicio} onChange={e => setDataInicio(e.target.value)} required />
          </div>
          <div>
            <Label>Data fim *</Label>
            <Input type="date" value={dataFim} onChange={e => setDataFim(e.target.value)} required />
          </div>
        </div>
        <Button variant="hero" onClick={handleContinuar}>
          <FileText className="h-4 w-4 mr-2" /> Continuar
        </Button>
      </CardContent>
    </Card>
  );
}

export default Admin;
